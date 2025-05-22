<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseContents;
use Illuminate\Http\Request;
use App\Models\CourseSections;
use App\Models\QuizAttempts;

class CourseContentsController
{
    public function storeQuiz(Course $course, CourseSections $courseSection, Request $request)
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
        $validateData['content_type'] = 'quiz';

        // sementara default 1
        $validateData['max_attempt'] = 1;

        $insert = CourseContents::create($validateData);

        if ($insert) {
            return redirect()->route('course.show', ['course' => $course->id])->with('successToast', 'Berhasil menambahkan konten');
        } else {
            return redirect()->route('course.show', ['course' => $course->id])->with('errorToast', 'Gagal menambahkan konten');
        }
    }

    public function deleteContent(Course $course, CourseContents $courseContents)
    {
        $delete = CourseContents::destroy($courseContents->id);

        if ($delete) {
            return redirect()->route('course.show', ['course' => $course->id])->with('successToast', 'Berhasil menghapus konten');
        } else {
            return redirect()->route('course.show', ['course' => $course->id])->with('errorToast', 'Gagal menghapus konten');
        }
    }

    public function editContent(Course $course, CourseContents $courseContents, $tipe)
    {
        $data = [
            'title' => 'Edit content',
            'content' => $courseContents,
            'course' => $course,
        ];

        return view('admin.course.editContent-' . ucfirst($tipe), $data);
    }

    public function updateContent(Course $course, CourseContents $courseContents, Request $request)
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

        $update = CourseContents::where('id', $courseContents->id)->update($validateData);

        if ($update) {
            return redirect()->route('course.show', ['course' => $course->id])->with('successToast', 'Berhasil update konten');
        } else {
            return redirect()->route('course.show', ['course' => $course->id])->with('errorToast', 'Gagal update konten');
        }
    }

    public function showContent(Course $course, CourseContents $courseContents, $tipe)
    {
        $data = [
            'title' => 'Quiz',
            'script' => 'showContent' . ucfirst($tipe) . '_script',
            'course' => $course,
            'content' => $courseContents,
            'question' => $courseContents->quiz_question,
            'studentAttempt' => $courseContents->studentAttempt,
        ];

        return view('admin.course.showContent-' . ucfirst($tipe), $data);
    }

    public function changeAttemptReview(Request $request)
    {
        $review = '';
        if ($request->text == 'No') {
            $review = true;
            $reviewText = 'Yes';
        } else {
            $review = false;
            $reviewText = 'No';
        }

        $update = QuizAttempts::where(['id' => $request->attempt_id, 'course_content_id' => $request->content_id])->update([
            'review' => $review
        ]);

        if ($update) {
            return response()->json([
                'success' => true,
                'message' => "berhasil update status review",
                'review' => $reviewText
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "berhasil update status review",
            ]);
        }
    }


    public function changeAttemptReviewAll(Request $request)
    {
        $reviewBool = $request->all == 'true' ? 1 : 0;
        $update = QuizAttempts::where('course_content_id', $request->content_id)->update([
            'review' => $reviewBool
        ]);

        if ($update) {
            return response()->json([
                'success' => true,
                'message' => 'berhasil mengubah status review semua siswa'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'gagal mengubah status review semua siswa'
            ]);
        }
    }
}
