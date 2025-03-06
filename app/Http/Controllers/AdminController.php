<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController
{
    function index()
    {
        $data = [
            'title' => 'Admin'
        ];

        return view('admin.index', $data);
    }
}
