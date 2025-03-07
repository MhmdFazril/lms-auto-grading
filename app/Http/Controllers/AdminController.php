<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController
{
    public function index()
    {
        $data = [
            'title' => 'Site Administration'
        ];

        return view('admin.index', $data);
    }


    public function addTeacher()
    {
        $data = [
            'title' => 'Add User',
            'script' => 'addUser_script',
            'role' => 'Teacher'
        ];

        return view('admin.users.addUser', $data);
    }

    public function addStudent()
    {
        $data = [
            'title' => 'Add User',
            'role' => 'Student'
        ];

        return view('admin.users.addUser', $data);
    }

    public function insertUser(Request $request)
    {
        $validateData = $request->validate([
            'nip' => 'required|string|max:20|unique:users,nip',
            'nama' => 'required|string|max:100',
            'tempat_tgl_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'alamat' => 'string',
            'telp' => 'required|numeric|digits_between:10,15',
            'wa' => 'required|numeric|digits_between:10,15',
            'pass' => 'required|string|min:8',
            'email' => 'required|email|unique:users,email',
            'gambar' => 'file|image|max:1024',
        ]);

        if ($request->file('gambar')) {

            $fileName = str_replace(' ', '_', $validateData['nama']);
            $fileName = time() . '_' . $fileName;

            $validateData['image'] = $request->file('gambar')->store($fileName);
        }

        $validateData['password'] = Hash::make($validateData['pass']);

        $validateData['role'] = 'teacher';

        User::create($validateData);

        // return redirect(route('site-admin'))->with('success', 'User berhasil ditambahkan.');
    }
}
