<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController
{

    function dashboard()
    {
        $data = [
            'title' => 'Dashboard',
        ];

        return view('menus.dashboard', $data);
    }
}
