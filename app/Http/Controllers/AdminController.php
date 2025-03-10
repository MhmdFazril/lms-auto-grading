<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            'script' => 'addTeacher_script',
            'role' => 'Teacher'
        ];

        return view('admin.users.addTeacher', $data);
    }

    public function addStudent()
    {
        $data = [
            'title' => 'Add User',
            'script' => 'addStudent_script',
            'role' => 'Student'
        ];

        return view('admin.users.addStudent', $data);
    }

    public function createTeacher(Request $request)
    {
        $validateData = $request->validate([
            'nip' => 'required|string|max:20|unique:users,nip',
            'nama' => 'required|string|max:100',
            'tempat_tgl_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'alamat' => 'string|nullable',
            'telp' => 'required|numeric|digits_between:10,15',
            'wa' => 'required|numeric|digits_between:10,15',
            'password' => 'required|string|min:8',
            'email' => 'required|email|unique:users,email',
            'gambar' => 'file|image|max:2048',
        ]);

        if ($request->file('gambar')) {
            $validateData['gambar'] = $request->file('gambar')->store('image-profile');
        }

        $validateData['password'] = Hash::make($validateData['passwordd']);

        User::create($validateData);

        return redirect(route('site-admin'))->with('successToast', 'User berhasil ditambahkan.');
    }

    public function createStudent(Request $request)
    {
        $validateData = $request->validate([
            'nisn' => 'required|string|max:20|unique:users,nisn',
            'nama' => 'required|string|max:100',
            'wali' => 'required|string|max:100',
            'alamat_wali' => 'string|nullable',
            'tempat_tgl_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'alamat' => 'string|nullable',
            'telp' => 'required|numeric|digits_between:10,15',
            'telp_wali' => 'required|numeric|digits_between:10,15',
            'wa' => 'required|numeric|digits_between:10,15',
            'password' => 'required|string|min:8',
            'email' => 'required|email|unique:users,email',
            'gambar' => 'file|image|max:2048',
        ]);


        if ($request->file('gambar')) {
            $validateData['gambar'] = $request->file('gambar')->store('image-profile');
        }

        $validateData['password'] = Hash::make($validateData['password']);

        User::create($validateData);

        return redirect(route('site-admin'))->with('successToast', 'User berhasil ditambahkan.');
    }

    public function userListing()
    {
        $data = [
            'title' => 'List of Users',
            'users' => User::all(),
            'script' => 'userListing_script',
        ];

        return view('admin.users.userListing', $data);
    }

    public function editTeacher(User $user)
    {
        $data = [
            'title' => 'Edit User',
            'script' => 'editUser_script',
            'role' => 'Teacher',
            'user' => $user
        ];

        return view('admin.users.editUser', $data);
    }

    public function updateUser(Request $request)
    {
        if ($request->role == 'teacher') {

            $rules = [
                'nama' => 'required|string|max:100',
                'tempat_tgl_lahir' => 'required|string|max:100',
                'tgl_lahir' => 'required|date',
                'alamat' => 'string|nullable',
                'telp' => 'required|numeric|digits_between:10,15',
                'wa' => 'required|numeric|digits_between:10,15',
                'gambar' => 'file|image|max:2048',
            ];

            if ($request->nip_old !== $request->nip) {
                $rules['nip'] = 'required|string|max:20|unique:users,nip';
            } else {
                $rules['nip'] = 'required|string|max:20';
            }

            if ($request->email_old !== $request->email) {
                $rules['email'] = 'required|string|max:20|unique:users,email';
            } else {
                $rules['email'] = 'required|string|max:20';
            }

            if ($request->password !== null) {
                $rules['password'] = 'string|min:8';
            }

            $validateData = $request->validate($rules);

            if ($request->password != null) {
                $validateData['password'] = Hash::make($validateData['password']);
            }
        } else {

            $rules = [
                'nama' => 'required|string|max:100',
                'tempat_tgl_lahir' => 'required|string|max:100',
                'tgl_lahir' => 'required|date',
                'alamat' => 'string|nullable',
                'telp' => 'required|numeric|digits_between:10,15',
                'wa' => 'required|numeric|digits_between:10,15',
                'gambar' => 'file|image|max:2048',
            ];

            if ($request->nisn_old !== $request->nisn) {
                $rules['nisn'] = 'required|string|max:20|unique:users,nisn';
            } else {
                $rules['nisn'] = 'required|string|max:20';
            }

            if ($request->email_old !== $request->email) {
                $rules['email'] = 'required|string|max:20|unique:users,email';
            } else {
                $rules['email'] = 'required|string|max:20';
            }

            if ($request->password !== null) {
                $rules['password'] = 'string|min:8';
            }

            $validateData = $request->validate($rules);

            if ($request->password != null) {
                $validateData['password'] = Hash::make($validateData['password']);
            }
        }
        if ($request->file('gambar')) {
            if ($request->gambar_old) {
                Storage::delete($request->gambar_old);
            }
            $validateData['gambar'] = $request->file('gambar')->store('image-profile');
        } else if ($request->gambar_old !== null && !Storage::exists($request->gambar_old)) {
            $validateData['gambar'] = null;
        }


        User::where('id', $request->id)->update($validateData);

        return redirect(route('userListing'))->with('successToast', 'User ' . $request->nama . ' berhasil diperbaharui.');
    }
}
