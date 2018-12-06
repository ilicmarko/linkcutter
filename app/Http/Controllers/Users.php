<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\User;

// Ovo dve funkcije su mogle da zovu AuthController

class Users extends Controller
{
    public function register(Request $request) {
        $rules = [
            'name'  => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = $request->validate($rules);
        
        $user = User::create([
            'name' => $validator['name'],
            'email' => $validator['email'],
            'password' => bcrypt($validator['password']),
        ]);

        $token = auth()->login($user);

        Cookie::queue('TOKEN', $token, 60 * 24 * 365);
        
        return redirect('/');
    }

    public function login(Request $request) {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = $request->validate($rules);
        
        if (!$token = auth()->attempt($validator)) {
            return redirect('login')->with('error', 'Login info is wrong!');
        }

        Cookie::queue('TOKEN', $token, 60 * 24 * 365);
        
        return redirect('/');
    }
}
