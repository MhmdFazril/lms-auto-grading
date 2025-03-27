<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Major;
use App\Models\Course;
use App\Models\Sclass;
use Illuminate\Http\Request;
use App\Models\CourseContents;
use App\Models\CourseEnrollment;
use App\Models\CourseSections;
use Illuminate\Support\Facades\Storage;

class CourseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Course Master',
            'script' => 'courseListing_script',
            'courses' => Course::where('aktif', true)->orderBy('nama', 'asc')->get(),
            'majors' => Major::where('aktif', true)->orderBy('nama', 'asc')->get(),
        ];

        return view('admin.course.courseListing', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Add Course',
            'script' => 'addCourse_script',
            'teachers' => User::where(['role' => 'teacher', 'aktif' => true])
                ->orderBy('nama', 'asc')
                ->get(),
            'majors' => Major::where('aktif', true)->get(),
        ];

        return view('admin.course.addCourse', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|string|max:100|unique:courses',
            'teacher_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|file|image|max:2048',
            'major_id' => 'required|integer|max_digits:2',
            'section' => 'required|integer|max_digits:2',
        ]);

        if ($request->file('gambar')) {
            $validateData['gambar'] = 'storage/' . $request->file('gambar')->store('image-course');
        } else {
            $validateData['gambar'] = 'asset/background_course' . rand(2, 7) . '.jpg';
        }
        $validateData['academic_year_id'] = '1';

        $jmlSection = $validateData['section'];
        unset($validateData["section"]);

        $courseInsert = Course::create($validateData);

        if ($courseInsert) {
            for ($i = 0; $i <= $jmlSection; $i++) {
                CourseSections::create([
                    'course_id' => $courseInsert->id,
                    'nama' => $i == 0 ? 'Information' : 'section ' . $i,
                    'posisi' => $i,
                ]);
            }
        }

        return redirect()->route('course.index')->with('successToast', 'Course berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $data = [
            'title' => ucwords(strtolower($course->nama)),
            'script' => 'showCourse_script',
            'sections' => CourseSections::with('contents')->where('course_id', $course->id)->get(),
            'course' => $course,
        ];

        return view('admin.course.showCourse', $data);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $data = [
            'title' => 'Edit Course',
            'script' => 'editCourse_script',
            'teachers' => User::where(['role' => 'teacher', 'aktif' => true])
                ->orderBy('nama', 'asc')
                ->get(),
            'majors' => Major::where('aktif', true)->get(),
            'course' => $course,
            // 'section' => $course->course_sections->count(),
        ];

        return view('admin.course.editCourse', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $rules = [
            'teacher_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|file|image|max:2048',
            'major_id' => 'required|integer|max_digits:2',
        ];

        if ($request->nama_old == $request->nama) {
            $rules['nama'] = 'required|string|max:100';
        } else {
            $rules['nama'] = 'required|string|max:100|unique:courses';
        }

        $validateData = $request->validate($rules);

        if ($request->file('gambar')) {
            $validateData['gambar'] = 'storage/' . $request->file('gambar')->store('image-course');

            $gambar_old = substr($request->gambar_old, 0, 7);
            if ($gambar_old == 'storage') {
                Storage::delete(substr($request->gambar_old, 8));
            }
        }

        $validateData['academic_year_id'] = '1';

        $update = Course::where('id', $course->id)->update($validateData);

        if ($update) {
            return redirect()->route('course.index')->with('successToast', 'Course berhasil diupdate.');
        } else {
            return redirect()->route('course.index')->with('errorToast', 'Course gagal diupdate.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        if (strpos($course->gambar, 'storage') !== false) {
            Storage::delete(substr($course->gambar, 8));
        }

        Course::destroy($course->id);

        return redirect()->route('course.index')->with('successToast', 'Berhasil menghapus course ' . $course->nama);
    }


    public function getParticipant(Request $request)
    {
        if ($request->filter == 'all') {
            $students = User::where(['users.aktif' => true, 'users.role' => 'student'])
                ->leftJoin('sclasses', 'sclasses.students_id', '=', 'users.id')
                ->leftJoin('mclasses', 'mclasses.id', '=', 'sclasses.mclass_id')
                ->orderBy('sclasses.mclass_id', 'asc')
                ->orderBy('users.nama', 'asc')
                ->select('users.*', 'sclasses.mclass_id', 'mclasses.nama as mclass_nama')
                ->get();
        } else {
            $students = User::where(['users.aktif' => true, 'users.role' => 'student', 'majors.id' => $request->filter])
                ->leftJoin('sclasses', 'sclasses.students_id', '=', 'users.id')
                ->leftJoin('mclasses', 'mclasses.id', '=', 'sclasses.mclass_id')
                ->leftJoin('majors', 'majors.id', '=', 'users.major_id')
                ->orderBy('sclasses.mclass_id', 'asc')
                ->orderBy('users.nama', 'asc')
                ->select('users.*', 'sclasses.mclass_id', 'mclasses.nama as mclass_nama')
                ->get();
        }

        $selectedItem = CourseEnrollment::where('course_id', $request->course_id)
            ->pluck('student_id');

        return response()->json([
            'success' => 'true',
            'students' => $students,
            'selectedItem' => $selectedItem,
        ]);
    }

    public function saveParticipant(Request $request)
    {
        $item = explode(',', $request->item);
        $oldItem = explode(',', $request->oldItem);

        $item = array_map('intval', $item);
        $oldItem = array_map('intval', $oldItem);

        $toDelete = array_diff($oldItem, $item);
        if (!empty($toDelete)) {
            CourseEnrollment::where('course_id', $request->course_id)
                ->whereIn('student_id', $toDelete)
                ->delete();
        }

        $toInsert = array_diff($item, $oldItem);
        foreach ($toInsert as $val) {
            CourseEnrollment::create([
                'course_id' => $request->course_id,
                'student_id' => $val,
            ]);
        }

        $selectedItem = CourseEnrollment::where('course_id', $request->course_id)
            ->pluck('student_id');

        return response()->json([
            'success' => true,
            'selectedItem' => $selectedItem,
        ]);
    }


    public function editSetting(Course $course, CourseSections $courseSection)
    {
        $data = [
            'title' => 'Setting ' . strtolower($course->nama) . ' section',
            'section' => $courseSection,
            'course_id' => $course->id,
        ];

        return view('admin.course.editSection', $data);
    }

    public function editSettingPost(Course $course, CourseSections $courseSection, Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|max:100|string',
            'deskripsi' => 'nullable|string',
        ]);

        $update = CourseSections::where('id', $courseSection->id)->update($validateData);

        if ($update) {
            return redirect()->route('course.show', ['course' => $course->id])->with('successToast', 'Berhasil update section');
        } else {
            return redirect()->route('course.show', ['course' => $course->id])->with('errorToast', 'Kesalahan sistem. Gagal update section');
        }
    }

    public function addSetting(Course $course)
    {
        $data = [
            'title' => 'Add section',
            'course_id' => $course->id,
        ];

        return view('admin.course.addSection', $data);
    }

    public function addSettingPost(Course $course, Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|max:100|string',
            'deskripsi' => 'nullable|string',
        ]);

        $validateData['course_id'] = $course->id;
        $insert = CourseSections::create($validateData);

        if ($insert) {
            return redirect()->route('course.show', ['course' => $course->id])->with('successToast', 'Berhasil menambah section');
        } else {
            return redirect()->route('course.show', ['course' => $course->id])->with('errorToast', 'Kesalahan sistem. Gagal menambah section');
        }
    }

    public function visibilitySections(Request $request)
    {
        $show = CourseSections::where('id', $request->section_id)->update(['show' => $request->show]);

        return response()->json([
            'success' => $show,
        ]);
    }

    public function updateSection(Request $request)
    {
        $show = CourseSections::where('id', $request->section_id)->update(['nama' => $request->new_text]);

        return response()->json([
            'success' => $show,
        ]);
    }

    public function deleteSection(Course $course, CourseSections $courseSection,)
    {
        $delete = CourseSections::destroy($courseSection->id);

        if ($delete) {
            return redirect()->route('course.show', ['course' => $course->id])->with('successToast', 'Berhasil menghapus section');
        } else {
            return redirect()->route('course.show', ['course' => $course->id])->with('errorToast', 'Gagal menghapus section');
        }
    }


    public function addContent(Course $course, CourseSections $courseSection, $tipe)
    {
        $data = [
            'title' => 'add ' . $tipe,
            'script' => 'addContent' . $tipe . '_script',
            'course' => $course,
            'courseSection' => $courseSection,
        ];

        return view('admin.course.addContent-' . $tipe, $data);
    }
}
