<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\QuizAttempts;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use App\Models\CourseContents;
use App\Models\QuizAnswer;

class QuizQuestionController
{
    public function createQuestion(Course $course, CourseContents $courseContents, $question_type)
    {
        $data = [
            'title' => 'add Question',
            'script' => 'addQuestion' . ucfirst($question_type) . '_script',
            'course_id' => $course->id,
            'content_id' => $courseContents->id,
            'question_type' => $question_type,
        ];

        return view('admin.course.addQuestion-' . ucfirst($question_type), $data);
    }


    public function storeQuestion(Course $course, CourseContents $courseContents, $question_type, Request $request)
    {
        if ($question_type == 'multiple') {
            $validatedData = $request->validate([
                'question_text' => 'required|string',
                'bobot' => 'required|integer',
                'opsi1' => 'nullable|string',
                'opsi2' => 'nullable|string',
                'opsi3' => 'nullable|string',
                'opsi4' => 'nullable|string',
                'opsi5' => 'nullable|string',

                'correct_answer' => ['required', function ($attribute, $value, $fail) use ($request) {
                    $validAnswers = [];
                    if ($request->has('opsi1')) $validAnswers[] = 'a';
                    if ($request->has('opsi2')) $validAnswers[] = 'b';
                    if ($request->has('opsi3')) $validAnswers[] = 'c';
                    if ($request->has('opsi4')) $validAnswers[] = 'd';
                    if ($request->has('opsi5')) $validAnswers[] = 'e';

                    if (!in_array($value, $validAnswers)) {
                        $fail('Jawaban benar harus sesuai dengan opsi yang diisi.');
                    }
                }],
            ]);

            $options = [];
            if ($request->has('opsi1')) $options['a'] = $request->opsi1;
            if ($request->has('opsi2')) $options['b'] = $request->opsi2;
            if ($request->has('opsi3')) $options['c'] = $request->opsi3;
            if ($request->has('opsi4')) $options['d'] = $request->opsi4;
            if ($request->has('opsi5')) $options['e'] = $request->opsi5;

            $filteredOptions = array_filter($options, function ($value) {
                return !empty($value);
            });

            $dataInsert = [
                'course_content_id' => $courseContents->id,
                'question_text' => $validatedData['question_text'],
                'question_type' => $question_type,
                'option' => $filteredOptions,
                'correct_answer' => $validatedData['correct_answer'],
                'bobot' => $validatedData['bobot'],
            ];
        } else {
            $validatedData = $request->validate([
                'question_text' => 'required|string',
                'bobot' => 'required|integer',
                'correct_answer' => 'required|string',
                'jenis_soal' => 'required|string'
            ]);


            $dataInsert = [
                'course_content_id' => $courseContents->id,
                'question_text' => $validatedData['question_text'],
                'question_type' => $question_type,
                'correct_answer' => $validatedData['correct_answer'],
                'bobot' => $validatedData['bobot'],
                'jenis_soal' => $validatedData['jenis_soal'],
            ];
        }

        $quizQuestion = QuizQuestion::create($dataInsert);

        if ($quizQuestion) {
            return redirect()->route('course.content.show-content', ['course' => $course->id, 'courseContents' => $courseContents->id, 'tipe' => 'Quiz'])->with('successToast', 'Berhasil menambahkan soal');
        } else {
            return redirect()->route('course.content.show-content', ['course' => $course->id, 'courseContents' => $courseContents->id, 'tipe' => 'Quiz'])->with('errorToast', 'Gagal menambahkan soal');
        }
    }


    public function deleteQuestion(Course $course, CourseContents $courseContents, $question)
    {
        $delete = QuizQuestion::destroy($question);

        if ($delete) {
            return redirect()->route('course.content.show-content', ['course' => $course->id, 'courseContents' => $courseContents->id, 'tipe' => 'Quiz'])->with('successToast', 'Berhasil menghapus soal');
        } else {
            return redirect()->route('course.content.show-content', ['course' => $course->id, 'courseContents' => $courseContents->id, 'tipe' => 'Quiz'])->with('errorToast', 'Gagal menghapus soal');
        }
    }

    public function editQuestion(Course $course, CourseContents $courseContents, QuizQuestion $quizQuestion, $question_type)
    {
        $data = [
            'title' => 'edit Question',
            'script' => 'editQuestion' . ucfirst($question_type) . '_script',
            'course_id' => $course->id,
            'content_id' => $courseContents->id,
            'question_type' => $question_type,
            'question' => $quizQuestion,
        ];

        return view('admin.course.editQuestion-' . ucfirst($question_type), $data);
    }

    public function updateQuestion(Course $course, CourseContents $courseContents, QuizQuestion $quizQuestion, $question_type, Request $request)
    {
        if ($question_type == 'multiple') {
            $validatedData = $request->validate([
                'question_text' => 'required|string',
                'bobot' => 'required|integer',
                'opsi1' => 'nullable|string',
                'opsi2' => 'nullable|string',
                'opsi3' => 'nullable|string',
                'opsi4' => 'nullable|string',
                'opsi5' => 'nullable|string',

                'correct_answer' => ['required', function ($attribute, $value, $fail) use ($request) {
                    $validAnswers = [];
                    if ($request->has('opsi1')) $validAnswers[] = 'a';
                    if ($request->has('opsi2')) $validAnswers[] = 'b';
                    if ($request->has('opsi3')) $validAnswers[] = 'c';
                    if ($request->has('opsi4')) $validAnswers[] = 'd';
                    if ($request->has('opsi5')) $validAnswers[] = 'e';

                    if (!in_array($value, $validAnswers)) {
                        $fail('Jawaban benar harus sesuai dengan opsi yang diisi.');
                    }
                }],
            ]);

            $options = [];
            if ($request->has('opsi1')) $options['a'] = $request->opsi1;
            if ($request->has('opsi2')) $options['b'] = $request->opsi2;
            if ($request->has('opsi3')) $options['c'] = $request->opsi3;
            if ($request->has('opsi4')) $options['d'] = $request->opsi4;
            if ($request->has('opsi5')) $options['e'] = $request->opsi5;

            $dataUpdate = [
                'course_content_id' => $courseContents->id,
                'question_text' => $validatedData['question_text'],
                'question_type' => $question_type,
                'option' => $options,
                'correct_answer' => $validatedData['correct_answer'],
            ];
        } else {
            $validatedData = $request->validate([
                'question_text' => 'required|string',
                'bobot' => 'required|integer',
                'correct_answer' => 'required|string',
                'jenis_soal' => 'required|string',
            ]);

            $dataUpdate = [
                'course_content_id' => $courseContents->id,
                'question_text' => $validatedData['question_text'],
                'question_type' => $question_type,
                'correct_answer' => $validatedData['correct_answer'],
                'jenis_soal' => $validatedData['jenis_soal'],
            ];
        }

        $quizQuestion = QuizQuestion::where('id', $quizQuestion->id)->update($dataUpdate);

        if ($quizQuestion) {
            return redirect()->route('course.content.show-content', ['course' => $course->id, 'courseContents' => $courseContents->id, 'tipe' => 'Quiz'])->with('successToast', 'Berhasil mengupdate soal');
        } else {
            return redirect()->route('course.content.show-content', ['course' => $course->id, 'courseContents' => $courseContents->id, 'tipe' => 'Quiz'])->with('errorToast', 'Gagal mengupdate soal');
        }
    }

    public function correction(Course $course, CourseContents $courseContents, QuizAttempts $quizAttempt)
    {
        $start_time = date_create($quizAttempt->start_time);
        $end_time = date_create($quizAttempt->end_time);
        $diff = date_diff($start_time, $end_time);

        $duration = $diff->h . ' Jam ' . $diff->i . ' Menit ' . $diff->s . ' detik';

        $data = [
            'title' => 'Quiz Check',
            'script' => 'quizCorrection_script',
            'course' => $course,
            'content' => $courseContents,
            'attempt' => $quizAttempt,
            'answer' => $quizAttempt->studentAnswer,
            'duration' => $duration
        ];

        return view('admin.course.quizCorrection', $data);
    }


    public function saveCorrection(Request $request)
    {
        $scoreData = json_decode($request->score, true);
        $attemptScore = 0;

        foreach ($scoreData as $score) {
            $answerId = $score['answer_id'];
            $answerScore = $score['score'];
            $feedback = $score['feedback'] == "" ? null : $score['feedback'];

            $where = [
                'id' => $answerId,
                'quiz_attempts_id' => $request->attempt_id,
                'student_id' => $request->student_id,
            ];

            $correct = $answerScore > 0 ? true : false;
            $attemptScore += $answerScore;
            QuizAnswer::where($where)->update(['score' => $answerScore, 'isCorrect' => $correct, 'feedback' => $feedback]);
        }

        QuizAttempts::where('id', $request->attempt_id)->update(['score' => $attemptScore]);

        return response()->json([
            'success' => true,
            'message' => 'Perubahan disimpan'
        ]);
    }
}
