<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\QuizAttempts;
use Illuminate\Http\Request;
use App\Models\CourseContents;
use App\Models\Major;
use App\Models\QuizAnswer;
use Illuminate\Support\Facades\Auth;

class QuizAttemptsController
{
    public function attemptQuiz(CourseContents $courseContent, $idxQuestion, Request $request)
    {
        $quizAttemptsCek = QuizAttempts::where(['course_content_id' => $courseContent->id, 'student_id' => Auth::user()->id])->first();

        $firstAttempt = '';
        if (!$quizAttemptsCek) {
            $firstAttempt = $this->firstAttempt($courseContent);
        }

        $attempt_id = $quizAttemptsCek->id ?? $firstAttempt->id;
        $attempt = $quizAttemptsCek ?? $firstAttempt;

        if ($request->question_id != null && $request->student_answer != null) {
            $where = ['quiz_attempts_id' => $attempt_id, 'quiz_question_id' => $request->question_id, 'student_id' => Auth::user()->id];

            QuizAnswer::where($where)->update(['student_answer' => $request->student_answer]);
        }

        // jika belum finish
        if (!$request->finish_attempt) {
            $questionShow = QuizAnswer::where(['quiz_attempts_id' => $attempt_id, 'student_id' => Auth::user()->id, 'order' => $idxQuestion])->first();
            $allQuestion = QuizAnswer::where(['quiz_attempts_id' => $attempt_id, 'student_id' => Auth::user()->id])->get();

            $data = [
                'title' => 'Quiz',
                'script' => 'quizAttempt_script',
                'question' => $questionShow,
                'allQuestion' => $allQuestion,
                'content' => $courseContent,
                'attempt' => $attempt,
                'idxQuestion' => $idxQuestion,
            ];

            return view('student.quizAttempt', $data);
        }
        // jika sudah finish
        else {
            QuizAttempts::where(['course_content_id' => $courseContent->id, 'student_id' => Auth::user()->id])->update(['end_time' => date('Y-m-d H:i:s')]);
            return redirect()->route('quiz.finish', ['courseContents' => $courseContent->id]);
        }
    }

    public function firstAttempt($content)
    {
        $dataAttempts = [
            'course_content_id' => $content->id,
            'student_id' => Auth::user()->id,
            'start_time' => Carbon::now()->format('Y-m-d H:i:s'),
        ];

        $quizAttempts = QuizAttempts::create($dataAttempts);

        if ($quizAttempts) {
            $question = $content->quiz_question()->inRandomOrder()->get();

            $index = 1;
            foreach ($question as $val) {
                QuizAnswer::create([
                    'quiz_attempt_id' => $quizAttempts->id,
                    'quiz_question_id' => $val->id,
                    'student_id' => Auth::user()->id,
                    'order' => $index++,
                ]);
            }

            return $quizAttempts;
        }

        return false;
    }

    public function finishQuiz(CourseContents $courseContents)
    {
        $quizAttempts = QuizAttempts::with('studentAnswer')->where(['course_content_id' => $courseContents->id, 'student_id' => Auth::user()->id])->first();

        $major = Major::where('id', Auth::user()->major_id)->first();


        $startTime = Carbon::parse($quizAttempts->start_time);
        $timeLimit = $courseContents->time_limit;
        $closeQuiz = Carbon::parse($courseContents->close_quiz);
        $currentTime = Carbon::now();

        $endTime = match ($courseContents->satuan) {
            'menit' => $startTime->copy()->addMinutes($timeLimit),
            'jam' => $startTime->copy()->addHours($timeLimit),
            'detik' => $startTime->copy()->addSeconds($timeLimit),
            default => $startTime,
        };

        $overtime = $currentTime->greaterThan($endTime) || $currentTime->greaterThan($closeQuiz);

        $data = [
            'title' => 'Finish Quiz',
            'content' => $courseContents,
            'attempt' => $quizAttempts,
            'major' => $major,
            'overtime' => $overtime
        ];


        return view('student.finishQuiz', $data);
    }

    public function submitQuiz(CourseContents $courseContents)
    {
        QuizAttempts::where(['course_content_id' => $courseContents->id, 'student_id' => Auth::user()->id])->update(['status' => 'finish']);

        return redirect()->route('student.show-content', ['course' => $courseContents->course->id, 'courseContent' => $courseContents->id, 'tipe' => 'quiz'])->with('successToast', 'Quiz diselesaikan');
    }
}
