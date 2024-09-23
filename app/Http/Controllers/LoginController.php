<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function loginView() {
        return view("login");
    }
    
    //This will authenticate the User
    public function authenticate(Request $request) {
        $validator = $request->validate([
            'email'=>'required|email',
            'password'=>'required',

        ]);

        if($validator) {
            if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
                 return redirect()->route('account.dashboard')->with('success','User Logged in Successfully');
            }else{
                return redirect()->route('account.login')->with('error','Either email or password is incorrect');
            }
            
        }else {
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }
    }

    public function registerView() {
        return view('register');
    }

    public function registration(Request $request) {

        $validator = $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required',
        ]);

        if($validator) {
             $user = new User();
             $user->name = $request->name;
             $user->email = $request->email;
             $user->password = Hash::make($request->password);
             $user->role = 'user';
             $user->save();
             return redirect()->route('account.login')->with('success','User Registered Successfully');
        }else{
            return redirect()->route('account.created')->withInput()->withErrors($validators);
        }

    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('account.login')->with('success','User logout Successfully');
        
    }


    
}
