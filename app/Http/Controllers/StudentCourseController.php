<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseContents;
use App\Models\QuizAttempts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentCourseController
{
    public function showContent(Course $course, CourseContents $courseContent, $tipe)
    {
        $data = [
            'title' => 'Show' . ucfirst($tipe),
            'script' => 'show' . ucfirst($tipe) . '_script',
            'course' => $course,
            'content' => $courseContent,
            'attemptInfo' => QuizAttempts::where(['course_content_id' => $courseContent->id, 'student_id' => Auth::user()->id])->first(),
        ];

        return view('student.showQuiz', $data);
    }
}
