<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SchoolController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'School Master',
            'script' => 'schoolListing_script',
            'schools' => School::all(),
        ];

        return view('admin.school.schoolListing', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Add School',
            'script' => 'addSchool_script',
        ];

        return view('admin.school.addSchool', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'nullable|email|unique:school',
            'gambar' => 'image|file|max:2048',
        ]);

        if ($request->file('gambar')) {
            $validateData['gambar'] = $request->file('gambar')->store('image-school');
        }

        School::create($validateData);

        return redirect()->route('school.index')->with('successToast', 'data sekolah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        $data = [
            'title' => 'Edit School',
            'script' => 'editSchool_script',
            'school' => $school,
        ];

        return view('admin.school.editSchool', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
    {
        $rules = [
            'email' => 'nullable|string',
        ];

        if ($request->nama_old !== $request->nama) {
            $rules['nama'] = 'required|string|max:100|unique:schools,nama';
        } else {
            $rules['nama'] = 'required|string|max:100';
        }

        if ($request->alamat_old !== $request->alamat) {
            $rules['alamat'] = 'required|string|unique:schools,alamat';
        } else {
            $rules['alamat'] = 'required|string';
        }

        $validateData = $request->validate($rules);

        if ($request->file('gambar')) {
            if ($request->gambar_old) {
                Storage::delete($request->gambar_old);
            }
            $validateData['gambar'] = $request->file('gambar')->store('image-school');
        }

        if ($request->remove_image) {
            Storage::delete($request->gambar_old);
            $validateData['gambar'] = null;
        }

        School::where('id', $school->id)->update($validateData);

        return redirect()->route('school.index')->with('successToast', 'Data sekolah berhasil diperbaharui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        School::destroy($school->id);

        return redirect()->route('school.index')->with('successToast', 'Data sekolah berhasil dihapus');
    }
}
