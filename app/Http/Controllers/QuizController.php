<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\CourseSections;

class QuizController
{
    public function store(Course $course, CourseSections $courseSection, Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'open_quiz' => 'required|date',
            'close_quiz' => 'required|date|after_or_equal:open_quiz',
            'time_limit' => 'required|integer',
            'satuan' => 'required',
            'shuffle' => 'required|boolean',
        ]);

        $validateData['course_id'] = $course->id;
        $validateData['course_sections_id'] = $courseSection->id;

        // sementara default 1
        $validateData['max_attempt'] = 1;

        $insert = Quiz::create($validateData);

        if ($insert) {
            return redirect()->route('course.show', ['course' => $course->id])->with('successToast', 'Berhasil menambahkan konten');
        } else {
            return redirect()->route('course.show', ['course' => $course->id])->with('errorToast', 'Gagal menambahkan konten');
        }
    }
}
