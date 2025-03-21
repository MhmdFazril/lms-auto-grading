<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Major;
use App\Models\Mclass;
use App\Models\Sclass;
use Illuminate\Http\Request;

class SclassController
{
    function index(Mclass $mclass)
    {
        $students = User::where(['role' => 'student', 'aktif' => true])
            ->whereNotIn('id', Sclass::pluck('students_id'))
            ->orderBy('nama', 'asc')->orderBy('major_id', 'asc')
            ->get();

        $sclass = Sclass::where('mclass_id', $mclass->id)->get();

        $teacher = User::where(['role' => 'teacher', 'aktif' => true])
            ->orderBy('nama', 'asc')
            ->get();

        $majors = Major::where('aktif', true)->get();

        $data = [
            'title' => 'Student Class',
            'mclass' => $mclass,
            'script' => 'sClass_script',
            'students' => $students,
            'sclass' => $sclass,
            'teacher' => $teacher,
            'majors' => $majors,
        ];

        return view('admin.class.sClass', $data);
    }

    function insert(Request $request)
    {
        $wali_kelas = $request->wali_kelas;
        $id_class = $request->id_class;
        $students = $request->students;
        $students = explode(',', $students);
        $count = 0;

        foreach ($students as $student) {
            $nourut = Sclass::getNourut($id_class);
            $nokey = Sclass::getNokey($id_class);

            $major_id = User::where('id', $student)->value('major_id');
            $dataInsert = [
                'nourut' => $nourut,
                'nokey' => $nokey,
                'students_id' => $student,
                'teacher_id' => $wali_kelas,
                'mclass_id' => $id_class,
                'major_id' => $major_id,
                'academic_year_id' => '1',
                'status' => 'aktif',
            ];

            $insert = Sclass::create($dataInsert);

            if ($insert) {
                $count++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'memindahkan ' . $count . ' data',
        ]);
    }

    function remove(Request $request)
    {
        $id_class = $request->id_class;
        $students = $request->students;
        $students = explode(',', $students);

        $count = 0;
        foreach ($students as $student) {

            $where = ['students_id' => $student, 'mclass_id' => $id_class];
            $delete = Sclass::where($where)->delete();

            if ($delete) {
                $count++;
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'memindahkan ' . $count . ' data',
        ]);
    }

    function filter(Request $request)
    {
        if ($request->filter == 'all') {
            $filter = User::where(['role' => 'student', 'aktif' => true])
                ->whereNotIn('id', Sclass::pluck('students_id'))
                ->get();
        } else {
            // $filter = User::where(['major_id' => $request->filter, 'aktif' => true])->orderBy('nama', 'asc')->get();
            $filter = User::where(['major_id' => $request->filter, 'aktif' => true])
                ->whereNotIn('id', Sclass::pluck('students_id'))
                ->get();
        }

        return response()->json([
            'success' => true,
            'data' => $filter
        ]);
    }


    function saveTeacher(Request $request)
    {
        $teacherClass_id = Mclass::find($request->id_class);
        if ($teacherClass_id->teacher_id != $request->teacher) {
            Mclass::where('id', $request->id_class)->update(['teacher_id' => $request->teacher]);

            Sclass::where('mclass_id', $request->id_class)->update(['teacher_id' => $request->teacher]);
        }

        return response()->json(true);
    }
}
