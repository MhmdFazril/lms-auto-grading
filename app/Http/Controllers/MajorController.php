<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;

class MajorController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Major Master',
            'script' => 'majorListing_script',
            'majors' => Major::all(),
        ];

        return view('admin.major.majorListing', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Add Major',
            'script' => 'addMajor_script'
        ];

        return view('admin.major.addMajor', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        Major::create($validateData);

        return redirect()->route('major.index')->with('successToast', 'Berhasil menambahkan Jurusan ' . $validateData['nama']);
    }

    /**
     * Display the specified resource.
     */
    public function show(major $major)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(major $major)
    {
        $data = [
            'title' => 'Edit Major',
            'script' => 'editMajor_script',
            'major' => $major,
        ];

        return view('admin.major.editMajor', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, major $major)
    {
        $rules = [
            'deskripsi' => 'nullable|string'
        ];

        if ($request->nama_old !== $request->nama) {
            $rules['nama'] = 'required|string|max:100|unique:majors,nama';
        } else {
            $rules['nama'] = 'required|string|max:100';
        }

        $validateData = $request->validate($rules);

        Major::where('id', $major->id)->update($validateData);

        return redirect()->route('major.index')->with('successToast', 'Berhasil memperbaharui data jurusan ' . $validateData['nama']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(major $major)
    {
        Major::destroy($major->id);

        return redirect()->route('major.index')->with('successToast', 'Berhasil menghapus jurusan ' . $major->nama);
    }
}
