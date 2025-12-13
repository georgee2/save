<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }


    public function checkuser()
    {
        if(Auth::attempt(request(['email','password']))){

            return redirect()->route('Admin');                
        }

        else{
            return back()->withErrors([
                'message' => 'Please Check Your E-mail And Password']);
               
        }
    }

    public function logout()
    {
        auth::logout();
        return redirect()->route('login');
    
    }
}
