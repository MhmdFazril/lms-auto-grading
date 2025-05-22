<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\CourseContents;
use App\Imports\QuestionImport;
use App\Models\QuizQuestion;
use Maatwebsite\Excel\Facades\Excel;

class QuestionImportController
{
    public function uploadQuestion(Course $course, CourseContents $courseContent, Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,xls',
        ]);

        $data = Excel::toArray([], $request->file('file')->getRealPath())[0];
        $errorsInfo = [];

        $questions = collect($data)->skip(1)->filter(function ($row) {
            return collect($row)->filter(function ($cell) {
                return trim($cell) !== '';
            })->isNotEmpty();
        })->map(function ($row, $index) use (&$errorsInfo) {
            $errors = [];

            if (empty($row[1])) {
                $errors['bobot'] = 'Bobot soal harus terisi';
                $errorsInfo[] = 'Bobot soal harus terisi';
            }

            if (!is_numeric($row[1])) {
                $errors['bobot'] = 'Bobot harus berupa angka';
                $errorsInfo[] = 'Bobot harus berupa angka';
            }

            $jenis = strtolower($row[2] ?? '');
            if (!in_array($jenis, ['multiple', 'essay'])) {
                $errors['jenis'] = 'Jenis soal harus "multiple" atau "essay"';
                $errorsInfo[] = 'Jenis soal harus "multiple" atau "essay"';
            }

            if (empty($row[3])) {
                $errors['soal'] = 'Soal tidak boleh kosong';
                $errorsInfo[] = 'Soal tidak boleh kosong';
            }

            if ($jenis == 'multiple') {
                $jawaban = strtoupper($row[9] ?? '');
                if (!in_array($jawaban, ['A', 'B', 'C', 'D', 'E'])) {
                    $errors['jawaban_benar'] = 'Jawaban benar harus terisi A/B/C/D/E';
                    $errorsInfo[] = 'Jawaban benar harus terisi A/B/C/D/E';
                }
            }

            if ($jenis == 'essay' && empty($row[10])) {
                $errors['kunci_essay'] = 'Kunci jawaban essay harus diisi';
                $errorsInfo[] = 'Kunci jawaban essay harus diisi';
            }

            if ($jenis == 'essay' && empty($row[11])) {
                $errors['jenis_essay'] = 'Jenis soal essay harus diisi';
                $errorsInfo[] = 'Jenis soal essay harus diisi';
            }

            if ($jenis == 'essay' && $row[11] != 'terbatas' && $row[11] != 'bebas') {
                $errors['jenis_essay'] = 'Jenis soal essay pilih terbatas atau bebas';
                $errorsInfo[] = 'Jenis soal essay pilih terbatas atau bebas';
            }

            return [
                'no' => $row[0] ?? null,
                'bobot' => $row[1] ?? null,
                'jenis' => strtolower($row[2] ?? ''),
                'soal' => $row[3] ?? '',
                'a' => $row[4] ?? '',
                'b' => $row[5] ?? '',
                'c' => $row[6] ?? '',
                'd' => $row[7] ?? '',
                'e' => $row[8] ?? '',
                'jawaban_benar' => strtoupper($row[9] ?? ''),
                'kunci_essay' => $row[10] ?? '',
                'jenis_essay' => $row[11] ?? '',
                'errors' => $errors,
            ];
        })->toArray();


        session(['import_questions' => $questions]);

        $data = [
            'title' => 'Import Preview',
            'script' => 'importQuestion_script',
            'course' => $course,
            'content' => $courseContent,
            'questions' => $questions,
            'namaFile' => $request->file('file')->getClientOriginalName(),
            'errorsInfo' => $errorsInfo
        ];

        return view('admin.importFile.importQuestion', $data);
    }

    public function importQuestion(Course $course, CourseContents $courseContent)
    {
        $questions = session()->pull('import_questions');

        if (!empty($questions)) {
            foreach ($questions as $index => $question) {
                if ($question['jenis'] == 'essay') {
                    $dataInput = [
                        'course_content_id' => $courseContent->id,
                        'question_text' => $question['soal'],
                        'question_type' => $question['jenis'],
                        'correct_answer' => $question['kunci_essay'],
                        'bobot' => $question['bobot'],
                        'jenis_soal' => $question['jenis_essay'],
                    ];
                } else {
                    $options = [
                        'a' => $question['a'],
                        'b' => $question['b'],
                        'c' => $question['c'],
                        'd' => $question['d'],
                        'e' => $question['e'],
                    ];

                    $filteredOptions = array_filter($options, function ($value) {
                        return !empty($value);
                    });

                    $dataInput = [
                        'course_content_id' => $courseContent->id,
                        'question_text' => $question['soal'],
                        'question_type' => $question['jenis'],
                        'option' => $filteredOptions,
                        'correct_answer' => strtolower($question['jawaban_benar']),
                        'bobot' => $question['bobot'],
                    ];
                }

                QuizQuestion::create($dataInput);
            }

            return redirect()->route('course.content.show-content', ['course' => $course->id, 'courseContents' => $courseContent->id, 'tipe' => 'quiz'])->with('successToast', 'Soal berhasil di import');
        } else {
            return redirect()->route('course.content.show-content', ['course' => $course->id, 'courseContents' => $courseContent->id, 'tipe' => 'quiz'])->with('errorToast', 'Terjadi kesalahan. Data import kosong');
        }
    }
}
