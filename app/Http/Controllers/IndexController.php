<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController
{
    function index()
    {
        $data = [
            'title' => '',
        ];

        return view('index', $data);
    }
}
