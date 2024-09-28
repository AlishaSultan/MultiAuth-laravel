<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRegValidation;
use App\Http\Requests\UserloginValidation;
use App\Notifications\WelcomeUserNotification;
use App\Notifications\NotifyAdminForNewUser;
use Illuminate\Support\Facades\Notification;
use App\Models\UsersHistory;
use App\Events\UserLoggedIn;
use App\Models\User;

class LoginController extends Controller
{
    public function loginView() {
        return view("login");
    }
    
    //This will authenticate the User
    public function authenticate(UserloginValidation $request) {
            if (Auth::attempt(['email'=> $request->getEmail(),'password'=>$request->getPassword()])) {
                $user = Auth::user();


                 event(new UserLoggedIn($user));
               
               
               
            //     UsersHistory::create([
            //         'name'=>$user->name,
            //         'email'=>$user->email,
            //         'role'=>$user->role,
            //         'status'=>'active',
            //         'login_time'=>now(),
            //    ]);
                // Todo:   Event/Listeners, validation.php, FormRequest method introduce   

                //$user->notify(new WelcomeUserNotification($user));
                // Notification::route('mail','') // Todo: This email should be fetched from admin table
                // ->notify(new NotifyAdminForNewUser($user));
                return redirect()->route('account.dashboard')->with('success',__('validation.successDashboard.loggedIn'));
            }else{
                return redirect()->route('account.login')->with('error',__('validation.errorcred.credIncorrect'));
            }
    }

    public function registerView() {
        return view('register');
    }

    public function registration(UserRegValidation $request) {
             $user = new User();
             $user->name = $request->name;
             $user->email = $request->email;
             $user->password = Hash::make($request->password); // Todo: which algorithem is being used Hash
             $user->role = 'user';
             $user->save();

             return redirect()->route('account.login')->with('success',__('validation.successReg.RegSuccessfully')); // Todo: Lang 

    }

    public function logout(Request $request) {
        $user = Auth::user();
        UsersHistory::where('email',$user->email)
              ->where('status','active')
              ->update([
                'status'=>'inactive',
                'logout_time'=>now(),
              ]);
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('account.login')->with('success',__('validation.successOut.logout'));
    }
}
