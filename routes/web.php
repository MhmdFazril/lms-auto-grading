<?php

use App\Models\QuizAttempts;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LogosController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MclassController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SclassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\QuizAttemptsController;
use App\Http\Controllers\QuizQuestionController;
use App\Http\Controllers\StudentCourseController;
use App\Http\Controllers\CourseContentsController;
use App\Http\Controllers\QuestionImportController;


Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard.dashboard');

// =============== KHUSUS BELUM LOGIN ==============
Route::middleware('guest')->group(function () {
    // authentication
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
});

// =============== KHUSUS SUDAH LOGIN ==============
Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    // Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserController::class, 'profileUpdate'])->name('profile.update');

    // =============== PREFIX UNTUK ROLE ADMIN ==============
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/site-admin', [AdminController::class, 'index'])->name('site-admin');
        Route::get('/site-setting', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/site-setting/create', [DashboardController::class, 'create'])->name('dashboard.create');
        Route::post('/site-setting/store', [DashboardController::class, 'store'])->name('dashboard.store');
        Route::get('/site-setting/edit/{dashboard}', [DashboardController::class, 'edit'])->name('dashboard.edit');
        Route::post('/site-setting/update', [DashboardController::class, 'update'])->name('dashboard.update');
        Route::post('/site-setting/destroy/{dashboard}', [DashboardController::class, 'destroy'])->name('dashboard.destroy');


        Route::get('/addTeacher', [AdminController::class, 'addTeacher'])->name('addTeacher');
        Route::get('/addStudent', [AdminController::class, 'addStudent'])->name('addStudent');

        Route::get('/editTeacher/{user:nip}', [AdminController::class, 'editTeacher'])->name('editTeacher');
        Route::get('/editStudent/{user:nisn}', [AdminController::class, 'editStudent'])->name('editStudent');

        Route::post('/addTeacher', [AdminController::class, 'createTeacher'])->name('insertTeacher');
        Route::post('/addStudent', [AdminController::class, 'createStudent'])->name('insertStudent');

        Route::post('/editTeacher', [AdminController::class, 'updateTeacher'])->name('updateTeacher');
        Route::post('/editStudent', [AdminController::class, 'updateStudent'])->name('updateStudent');

        Route::get('/userListing', [AdminController::class, 'userListing'])->name('userListing');

        Route::post('/deleteUser/{user}', [AdminController::class, 'deleteUser'])->name('deleteUser');

        Route::get('/logos', [LogosController::class, 'logos'])->name('logos');
        Route::post('/logos/store', [LogosController::class, 'logosStore'])->name('logos.store');
        Route::post('/favicon/store', [LogosController::class, 'faviconStore'])->name('favicon.store');
        Route::post('/logos/removeLogos', [LogosController::class, 'removeLogos'])->name('logos.destroy');
        Route::post('/favicon/removeFavicon', [LogosController::class, 'removeFavicon'])->name('favicon.destroy');

        // resource controller school
        Route::resource('/school', SchoolController::class)->except('show');

        // resource controller school
        Route::resource('/academic-year', AcademicYearController::class)->except('show');

        // resource controller major
        Route::resource('/major', MajorController::class)->except('show');

        // resource controller major
        Route::resource('/mclass', MclassController::class)->except('show');

        Route::get('/sclass/{mclass}', [SclassController::class, 'index'])->name('sclass.index');
        Route::post('/sclass/insert', [SclassController::class, 'insert'])->name('sclass.insert');
        Route::post('/sclass/remove', [SclassController::class, 'remove'])->name('sclass.remove');
        Route::post('/sclass/filter', [SclassController::class, 'filter'])->name('sclass.filter');
        Route::post('/sclass/saveTeacher', [SclassController::class, 'saveTeacher'])->name('sclass.saveTeacher');

        // // resource controller course
        // Route::resource('/course', CourseController::class);

        Route::post('/course/getParticipant', [CourseController::class, 'getParticipant'])->name('course.getParticipant');
        Route::post('/course/saveParticipant', [CourseController::class, 'saveParticipant'])->name('course.saveParticipant');
    });


    // =============== UNTUK UMUM ==============
    Route::resource('/course', CourseController::class);


    // =============== KHUSUS ADMIN DAN TEACHER ==============
    Route::middleware('role:teacher,admin')->group(function () {
        Route::get('/course/section/edit-setting/{course}/{courseSection}', [CourseController::class, 'editSetting'])->name('course.section.edit-setting');
        Route::post('/course/section/edit-setting/{course}/{courseSection}', [CourseController::class, 'editSettingPost'])->name('course.section.edit-setting-post');

        Route::get('/course/section/add-setting/{course}', [CourseController::class, 'addSetting'])->name('course.section.add-setting');
        Route::post('/course/section/add-setting/{course}', [CourseController::class, 'addSettingPost'])->name('course.section.add-setting-post');

        Route::get('/course/section/delete/{course}/{courseSection}', [CourseController::class, 'deleteSection'])->name('course.section.delete-section');
        Route::post('/course/section/visibility}', [CourseController::class, 'visibilitySections'])->name('course.section.visibility');

        Route::post('/course/section/update', [CourseController::class, 'updateSection'])->name('course.section.update-section');

        Route::get('/course/section/addContent/{course}/{courseSection}/{tipe}', [CourseController::class, 'addContent'])->name('course.section.add-content');

        Route::post('/content/store/{course}/{courseSection}', [CourseContentsController::class, 'storeQuiz'])->name('course.content.store-quiz');
        Route::get('/content/delete/{course}/{courseContents}', [CourseContentsController::class, 'deleteContent'])->name('course.content.delete-content');

        Route::get('/content/edit/{course}/{courseContents}/{tipe}', [CourseContentsController::class, 'editContent'])->name('course.content.edit-content');
        Route::post('/content/update/{course}/{courseContents}', [CourseContentsController::class, 'updateContent'])->name('course.content.update-content');

        Route::get('/content/show/{course}/{courseContents}/{tipe}', [CourseContentsController::class, 'showContent'])->name('course.content.show-content');
        Route::post('/content/attempt/review', [CourseContentsController::class, 'changeAttemptReview'])->name('quiz.attempt.update-review');
        Route::post('/content/attempt/review/all', [CourseContentsController::class, 'changeAttemptReviewAll'])->name('quiz.attempt.update-review-all');

        Route::get('/content/createQuestion/{course}/{courseContents}/{question_type}', [QuizQuestionController::class, 'createQuestion'])->name('course.content.create-question');
        Route::post('/content/createQuestion/{course}/{courseContents}/{question_type}', [QuizQuestionController::class, 'storeQuestion'])->name('course.content.store-question');

        Route::get('/content/editQuestion/{course}/{courseContents}/{quizQuestion}/{question_type}', [QuizQuestionController::class, 'editQuestion'])->name('course.content.edit-question');
        Route::post('/content/editQuestion/{course}/{courseContents}/{quizQuestion}/{question_type}', [QuizQuestionController::class, 'updateQuestion'])->name('course.content.update-question');

        Route::get('/content/deleteQuestion/{course}/{courseContents}/{question}', [QuizQuestionController::class, 'deleteQuestion'])->name('course.content.delete-question');

        Route::get('/content/correction/{course}/{courseContents}/{quizAttempt}', [QuizQuestionController::class, 'correction'])->name('course.content.correct-question');

        Route::post('/content/correction/', [QuizQuestionController::class, 'saveCorrection'])->name('course.content.correct-question-save');

        Route::post('/import/question/upload/{course}/{courseContent}', [QuestionImportController::class, 'uploadQuestion'])->name('import.question.upload');
        Route::get('/import/question/import/{course}/{courseContent}', [QuestionImportController::class, 'importQuestion'])->name('import.question.import');
    });

    // =============== STUDENT ==============
    Route::middleware('role:student')->group(function () {
        Route::get('/student/content/show/{course}/{courseContent}/{tipe}', [StudentCourseController::class, 'showContent'])->name('student.show-content');
        Route::any('/quiz/attempt/{courseContent}/{idxQuestion}', [QuizAttemptsController::class, 'attemptQuiz'])->name('quiz.attempt');
        Route::get('/quiz/finish/{courseContents}', [QuizAttemptsController::class, 'finishQuiz'])->name('quiz.finish');
        Route::get('/quiz/submit/{courseContents}', [QuizAttemptsController::class, 'submitQuiz'])->name('quiz.submit');

        Route::get('/quiz/review/{course}/{courseContent}/{tipe}', [StudentCourseController::class, 'quizReview'])->name('quiz.review');
    });
});
