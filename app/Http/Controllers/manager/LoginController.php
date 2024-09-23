<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('manager.login');
    }

    public function authenticate(Request $request) {
        $validator = $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        if($validator) {
            if (Auth::guard('manager')->attempt(['email'=>$request->email,'password'=>$request->password])) {
                if(Auth::guard('manager')->user()->role != 'manager') {
                    Auth::guard('manager')->logout();
                    return redirect()->route('manager.login')->with('error',"You are not authorize to access manager dashboard");
                }else{
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
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('manager.login')->with('success','Manager logout Successfully');
        
    }
}
