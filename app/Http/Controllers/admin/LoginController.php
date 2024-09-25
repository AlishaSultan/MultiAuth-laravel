<?php
namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserloginValidation;
use App\Models\UsersHistory;
class LoginController extends Controller
{
    public function index() {
        return view('admin.login');
    }

    public function authenticate(UserloginValidation $request) {
        $validator = $request->validated();

        if($validator) {
            if (Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password])) {
                if (Auth::guard('admin')->user()->role != 'admin') {
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error','You are not authorize to view admin dashboard');
                }
                    $admin = Auth::guard('admin')->user();
                    UsersHistory::create([
                        'name'=>$admin->name,
                        'email'=>$admin->email,
                        'role'=>$admin->role,
                        'status'=>'active',
                        'login_time'=>now(),      
                    ]);
                    
                return redirect()->route('admin.dashboard')->with('success','Admin Logged in Successfully');
            }else{
                return redirect()->route('admin.login')->with('error','Either email or password is incorrect');
            }
            
        }else {
            return redirect()->route('admin.login')->withInput()->withErrors($validator);
        }
    }

    public function logout(Request $request) {
        $admin = Auth::guard('admin')->user();
        UsersHistory::where('email', $admin->email)
              ->where('status','active')
              ->update([
                'status'=>'inactive',
                'logout_time' => now(),
              ]);
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('admin.login')->with('success','Admin logout Successfully');
        
    }

}
