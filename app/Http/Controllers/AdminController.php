<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController
{
    function index()
    {
        $data = [
            'title' => 'Site Administration'
        ];

        return view('admin.index', $data);
    }


    function addTeacher()
    {
        $data = [
            'title' => 'Add User',
            'script' => 'addTeacher_script',
            'role' => 'Teacher'
        ];

        return view('admin.users.addTeacher', $data);
    }

    function addStudent()
    {
        $data = [
            'title' => 'Add User',
            'script' => 'addStudent_script',
            'role' => 'Student',
            'majors' => Major::where('aktif', true)->get(),
        ];

        return view('admin.users.addStudent', $data);
    }

    function createTeacher(Request $request)
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
            'jenis_kelamin' => 'required',
            'pernikahan' => 'required',
            'pendidikan' => 'nullable|string|max:20',
            'prodi' => 'nullable|string|max:20',
            'lembaga_pendidikan' => 'nullable|string|max:50',
            'tahun_lulus' => 'numeric|nullable',
        ]);

        if ($request->file('gambar')) {
            $validateData['gambar'] = $request->file('gambar')->store('image-user');
        }

        $validateData['password'] = Hash::make($validateData['password']);
        $validateData['role'] = 'teacher';

        User::create($validateData);

        return redirect()->route('userListing')->with('successToast', 'User berhasil ditambahkan.');
    }

    function createStudent(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|string|max:100',
            'tempat_tgl_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'string|nullable',
            'telp' => 'required|numeric|digits_between:10,15',
            'wa' => 'required|numeric|digits_between:10,15',
            'email' => 'nullable|email',
            'password' => 'required|string|min:8',
            'gambar' => 'file|image|max:2048',

            'major_id' => 'required|numeric',
            'nis' => 'required|string|max:20|unique:users,nis',
            'nisn' => 'required|string|max:20|unique:users,nisn',
            'nama_wali' => 'required|string|max:100',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'pekerjaan_wali' => 'required|string|max:100',
            'pekerjaan_ayah' => 'required|string|max:100',
            'pekerjaan_ibu' => 'required|string|max:100',
            'alamat_orwa' => 'string|nullable',
            'telp_orwa' => 'required|numeric|digits_between:10,15',
            'tahun_masuk' => 'numeric|required',
        ]);

        if ($request->file('gambar')) {
            $validateData['gambar'] = $request->file('gambar')->store('image-user');
        }

        $validateData['password'] = Hash::make($validateData['password']);

        User::create($validateData);

        return redirect()->route('userListing')->with('successToast', 'User berhasil ditambahkan.');
    }

    function userListing()
    {
        $data = [
            'title' => 'List of Users',
            'users' => User::all(),
            'script' => 'userListing_script',
        ];

        return view('admin.users.userListing', $data);
    }

    function editTeacher(User $user)
    {
        $data = [
            'title' => 'Edit User',
            'script' => 'editTeacher_script',
            'role' => 'Teacher',
            'user' => $user
        ];

        return view('admin.users.editTeacher', $data);
    }

    function editStudent(User $user)
    {
        $data = [
            'title' => 'Edit Student',
            'script' => 'editStudent_script',
            'role' => 'Student',
            'user' => $user
        ];

        return view('admin.users.editStudent', $data);
    }

    function updateTeacher(Request $request)
    {
        // dd($request);
        $rules = [
            'nama' => 'required|string|max:100',
            'tempat_tgl_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'alamat' => 'string|nullable',
            'telp' => 'required|numeric|digits_between:10,15',
            'wa' => 'required|numeric|digits_between:10,15',
            'email' => 'required|email',
            'gambar' => 'file|image|max:2048',
            'jenis_kelamin' => 'required',
            'pernikahan' => 'required',
            'pendidikan' => 'nullable|string|max:20',
            'prodi' => 'nullable|string|max:20',
            'lembaga_pendidikan' => 'nullable|string|max:50',
            'tahun_lulus' => 'numeric|nullable',
        ];

        if ($request->nip_old !== $request->nip) {
            $rules['nip'] = 'required|string|max:20|unique:users,nip';
        } else {
            $rules['nip'] = 'required|string|max:20';
        }

        if ($request->password !== null) {
            $rules['password'] = 'string|min:8';
        }

        $validateData = $request->validate($rules);

        if ($request->password != null) {
            $validateData['password'] = Hash::make($validateData['password']);
        }

        if ($request->file('gambar')) {
            if ($request->gambar_old) {
                Storage::delete($request->gambar_old);
            }
            $validateData['gambar'] = $request->file('gambar')->store('image-user');
        }

        if ($request->remove_image) {
            if ($request->gambar_old != null) {
                Storage::delete($request->gambar_old);
            }
            $validateData['gambar'] = null;
        }

        User::where('id', $request->id)->update($validateData);

        return redirect(route('userListing'))->with('successToast', 'User ' . $request->nama . ' berhasil diperbaharui.');
    }

    function updateStudent(Request $request)
    {

        $rules = [
            'nama' => 'required|string|max:100',
            'tempat_tgl_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'string|nullable',
            'telp' => 'required|numeric|digits_between:10,15',
            'wa' => 'required|numeric|digits_between:10,15',
            'email' => 'nullable|email',
            'gambar' => 'file|image|max:2048',

            'id_major' => 'required|numeric',
            'nama_wali' => 'required|string|max:100',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'pekerjaan_wali' => 'required|string|max:100',
            'pekerjaan_ayah' => 'required|string|max:100',
            'pekerjaan_ibu' => 'required|string|max:100',
            'alamat_orwa' => 'string|nullable',
            'telp_orwa' => 'required|numeric|digits_between:10,15',
            'tahun_masuk' => 'numeric|required',
        ];

        if ($request->nis_old !== $request->nis) {
            $rules['nis'] = 'required|string|max:20|unique:users,nis';
        } else {
            $rules['nis'] = 'required|string|max:20';
        }

        if ($request->nisn_old !== $request->nisn) {
            $rules['nisn'] = 'required|string|max:20|unique:users,nisn';
        } else {
            $rules['nisn'] = 'required|string|max:20';
        }

        if ($request->password !== null) {
            $rules['password'] = 'string|min:8';
        }

        $validateData = $request->validate($rules);

        if ($request->password != null) {
            $validateData['password'] = Hash::make($validateData['password']);
        }

        if ($request->file('gambar')) {
            if ($request->gambar_old) {
                Storage::delete($request->gambar_old);
            }
            $validateData['gambar'] = $request->file('gambar')->store('image-user');
        }

        if ($request->remove_image) {
            if ($request->gambar_old != null) {
                Storage::delete($request->gambar_old);
            }
            $validateData['gambar'] = null;
        }

        User::where('id', $request->id)->update($validateData);

        return redirect(route('userListing'))->with('successToast', 'User ' . $request->nama . ' berhasil diperbaharui.');
    }

    function deleteUser(User $user)
    {
        User::destroy($user->id);

        if ($user->gambar) {
            Storage::delete($user->gambar);
        }

        return redirect()->route('userListing')->with('successToast', 'User ' . $user->nama . ' berhasil dihapus');
    }
}
