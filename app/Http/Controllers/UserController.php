<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController
{
    function profile()
    {
        $data = [
            'title' => 'Profile',
            'script' => 'profile_script'
        ];

        return view('admin.users.profile', $data);
    }

    function profileUpdate(Request $request)
    {
        $request->validate([
            'wa' => 'required|numeric|digits_between:10,15',
            'alamat' => 'string|nullable',
            'gambar' => 'file|image|max:2048',
        ]);

        $dataInsert = [
            'wa' => $request->wa,
            'alamat' => $request->alamat,
        ];

        if ($request->file('gambar')) {
            if ($request->gambar_old) {
                Storage::delete($request->gambar_old);
            }
            $dataInsert['gambar'] = $request->file('gambar')->store('image-user');
        }

        $update = User::where('id', auth()->user()->id)->update($dataInsert);

        if ($update) {
            return redirect()->back()->with('successToast', 'Berhasil update profile');
        } else {
            return redirect()->back()->with('errorToast', 'Gagal update profile');
        }
    }
}
