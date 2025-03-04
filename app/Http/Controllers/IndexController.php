<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController
{
    function index()
    {
        return view('index');
    }
}
