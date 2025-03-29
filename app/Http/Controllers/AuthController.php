<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    function login()
    {
        $data = [
            'title' => 'Login Page',
            'script' => 'login_script',
        ];
        return view('auth.login', $data);
    }


    function auth(Request $request)
    {
        $user = User::where('email', $request->nomor)
            ->orWhere('nis', $request->nomor)
            ->orWhere('nip', $request->nomor)
            ->first();

        if ($user) {
            $userAttempt = [
                $user->getAuthIdentifierName() => $user->{$user->getAuthIdentifierName()},
                'password' => $request->password,
                'aktif' => true
            ];

            if (Auth::attempt($userAttempt)) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard')->with(
                    'successToast',
                    'Selamat datang ' .  ucfirst(strtolower(Auth::user()->nama))
                );
            }

            return back()->withInput()->with('errorToast', 'Akun tidak ditemukan atau password salah.');
        }

        return back()->withInput()->with('errorToast', 'Akun tidak ditemukan atau password salah.');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/login');
    }
}
