<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseContents;
use App\Models\QuizAnswer;
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

    public function quizReview(Course $course, CourseContents $courseContent, $tipe)
    {
        $answer = QuizAnswer::join('quiz_attempts', 'quiz_answers.quiz_attempts_id', '=', 'quiz_attempts.id')
            ->where('quiz_attempts.course_content_id', $courseContent->id)
            ->where('quiz_attempts.student_id', Auth::id())
            ->select('quiz_answers.*')
            ->orderby('quiz_answers.order', 'asc')
            ->get();

        $quizAttempt = QuizAttempts::where(['course_content_id' => $courseContent->id, 'student_id' => Auth::id()])->first();

        $start_time = date_create($quizAttempt->start_time);
        $end_time = date_create($quizAttempt->end_time);
        $diff = date_diff($start_time, $end_time);

        $duration = $diff->h . ' Jam ' . $diff->i . ' Menit ' . $diff->s . ' detik';

        $data = [
            'title' => 'Review' . ucfirst($tipe),
            'script' => 'quizReview_script',
            'course' => $course,
            'content' => $courseContent,
            'answerInfo' => $answer,
            'attempt' => $quizAttempt,
            'answer' => $quizAttempt->studentAnswer,
            'duration' => $duration
        ];

        return view('student.quizReview', $data);
    }
}
