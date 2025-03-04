<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController
{
    function login()
    {
        return view('auth.login');
    }
}
