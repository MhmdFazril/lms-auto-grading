<?php

namespace App\Http\Controllers;

use App\Models\Mclass;
use Illuminate\Http\Request;

class MclassController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Class Master',
            'script' => 'classListing_script',
            'classes' => Mclass::all(),
        ];

        return view('admin.class.classListing', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Add Class',
            'script' => 'addClass_script'
        ];

        return view('admin.class.addClass', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|string|max:50|unique:mclasses',
            'deskripsi' => 'nullable|string',
        ]);

        Mclass::create($validateData);

        return redirect()->route('mclass.index')->with('successToast', 'Berhasil menambahkan kelas baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(mclass $mclass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(mclass $mclass)
    {
        $data = [
            'title' => 'Edit Class',
            'script' => 'editClass_script',
            'class' => $mclass,
        ];

        return view('admin.class.editClass', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, mclass $mclass)
    {
        $rules = [
            'deskripsi' => 'nullable|string'
        ];

        if ($request->nama_old !== $request->nama) {
            $rules['nama'] = 'required|string|unique:mclasses';
        } else {
            $rules['nama'] = 'required|string';
        }

        $validateData = $request->validate($rules);

        Mclass::where('id', $mclass->id)->update($validateData);

        return redirect()->route('mclass.index')->with('successToast', 'Kelas ' . $validateData['nama'] . ' berhail di perbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(mclass $mclass)
    {
        Mclass::destroy($mclass->id);
        return redirect()->route('mclass.index')->with('successToast', 'Berhasil menghapus kelas ' . $mclass->nama);
    }
}
