<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD
use App\Http\Requests\UserloginValidation;
use App\Models\UsersHistory;
=======

>>>>>>> 91a85d6570c203d3eb1f6e99086185c423644701
class LoginController extends Controller
{
    public function index() {
        return view('manager.login');
    }

<<<<<<< HEAD
    public function authenticate(UserloginValidation $request) {
        $validator = $request->validated();
=======
    public function authenticate(Request $request) {
        $validator = $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);
>>>>>>> 91a85d6570c203d3eb1f6e99086185c423644701

        if($validator) {
            if (Auth::guard('manager')->attempt(['email'=>$request->email,'password'=>$request->password])) {
                if(Auth::guard('manager')->user()->role != 'manager') {
                    Auth::guard('manager')->logout();
                    return redirect()->route('manager.login')->with('error',"You are not authorize to access manager dashboard");
                }else{
<<<<<<< HEAD
                    $manager=Auth::guard('manager')->user();
                    UsersHistory::create([
                        'name'=>$manager->name,
                        'email'=>$manager->email,
                        'role' =>$manager->role,
                        'status'=>'active',
                        'login_time'=>now(),
                    ]);
=======
>>>>>>> 91a85d6570c203d3eb1f6e99086185c423644701
                    return redirect()->route('manager.dashboard')->with('success','Manager has logged In Successfully');
                }
            }else{
                return redirect()->route('manager.login')->with('error','Either password or email is incorrect');
            }
        }
        else {
            return redirect()->route('manager.login')->withInput()->withErrors($validator);
        }
    }

    public function logout(Request $request) {
<<<<<<< HEAD
        $manager = Auth::guard('manager')->user();
        UsersHistory::where('email',$manager->email)
                 ->where('status','active')
                 ->update([
                    'status'=>'inactive',
                    'logout_time'=>now()
                 ]);
=======
>>>>>>> 91a85d6570c203d3eb1f6e99086185c423644701
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('manager.login')->with('success','Manager logout Successfully');
        
    }
}
