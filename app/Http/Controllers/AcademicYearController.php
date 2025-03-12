<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Academic Year Master',
            'script' => 'academicYearListing_script',
            'years' => AcademicYear::all(),
        ];

        return view('admin.academic_year.academicYearListing', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Add Academic Year',
            'script' => 'addAcademicYear_script',
        ];

        return view('admin.academic_year.addAcademicYear', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataInsert = $request->validate([
            'tahun1' => 'required|numeric|unique:academic_years',
            'tahun2' => 'required|numeric|unique:academic_years',
            'catatan' => 'nullable|string',
        ]);

        AcademicYear::create($dataInsert);

        return redirect('/admin/site-admin')->with('successToast', 'Sukses menambahkan tahun akademik');
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicYear $academicYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicYear $academicYear)
    {
        $data = [
            'title' => 'Academic Year Edit',
            'script' => 'editAcademicYear_script',
            'year' => $academicYear,
        ];

        return view('admin.academic_year.editAcademicYear', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademicYear $academicYear)
    {

        $rules = [
            'catatan' => 'nullable|string'
        ];

        if ($request->tahun1 !== $request->tahun1_old) {
            $rules['tahun1'] = 'required|numeric|unique:academic_years';
        } else {
            $rules['tahun1'] = 'required|numeric';
        }

        if ($request->tahun2 !== $request->tahun2_old) {
            $rules['tahun2'] = 'required|numeric|unique:academic_years';
        } else {
            $rules['tahun2'] = 'required|numeric';
        }

        $request->validate($rules);

        $dataUpdate = [
            'tahun1' => $request->tahun1,
            'tahun2' => $request->tahun2,
            'catatan' => $request->catatan,
        ];

        AcademicYear::where('id', $academicYear->id)->update($dataUpdate);

        return redirect()->route('academic-year.index')->with('successToast', 'Sukses mengupdate tahun akademik');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicYear $academicYear)
    {
        AcademicYear::destroy($academicYear->id);

        return redirect('/admin/academic-year')->with('successToast', 'Tahun akademik berhasil dihapus');
    }
}
