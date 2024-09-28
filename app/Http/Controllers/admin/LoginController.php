<?php
<<<<<<< HEAD
=======

>>>>>>> 91a85d6570c203d3eb1f6e99086185c423644701
namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
<<<<<<< HEAD
use App\Http\Requests\UserloginValidation;
use App\Models\UsersHistory;
=======

>>>>>>> 91a85d6570c203d3eb1f6e99086185c423644701
class LoginController extends Controller
{
    public function index() {
        return view('admin.login');
    }

<<<<<<< HEAD
    public function authenticate(UserloginValidation $request) {
        $validator = $request->validated();

        if($validator) {
            if (Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password])) {
                if (Auth::guard('admin')->user()->role != 'admin') {
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error',__('validation.errorAuthorize.notAuthorize'));
                }
                    $admin = Auth::guard('admin')->user();
                    UsersHistory::create([
                        'name'=>$admin->name,
                        'email'=>$admin->email,
                        'role'=>$admin->role,
                        'status'=>'active',
                        'login_time'=>now(),      
                    ]);
                    
                return redirect()->route('admin.dashboard')->with('success',__('validation.successAdminIn.adminIn'));
            }else{
                return redirect()->route('admin.login')->with('error',__('validation.errorIncorrect.admincred'));
=======
    public function authenticate(Request $request) {
        $validator = $request->validate([
            'email'=>'required|email',
            'password'=>'required',

        ]);

        if($validator) {
            if (Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password])) {

                if (Auth::guard('admin')->user()->role != 'admin') {
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error','You are not authorize to view admin dashboard');
                }
                return redirect()->route('admin.dashboard')->with('success','Admin Logged in Successfully');
            }else{
                return redirect()->route('admin.login')->with('error','Either email or password is incorrect');
>>>>>>> 91a85d6570c203d3eb1f6e99086185c423644701
            }
            
        }else {
            return redirect()->route('admin.login')->withInput()->withErrors($validator);
        }
    }

    public function logout(Request $request) {
<<<<<<< HEAD
        $admin = Auth::guard('admin')->user();
        UsersHistory::where('email', $admin->email)
              ->where('status','active')
              ->update([
                'status'=>'inactive',
                'logout_time' => now(),
              ]);
=======
>>>>>>> 91a85d6570c203d3eb1f6e99086185c423644701
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('admin.login')->with('success','Admin logout Successfully');
        
    }

}
