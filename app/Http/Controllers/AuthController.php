<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController
{
    function login()
    {
        $data = [
            'title' => 'Login Page',
        ];
        return view('auth.login', $data);
    }


    function auth(Request $request)
    {
        return redirect('/dashboard')->with('successToast', 'Selamat datang');
    }
}
