<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseContentsController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LogosController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\MclassController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SclassController;
use App\Models\CourseContents;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('index');
// });


Route::get('/', [IndexController::class, 'index'])->name('index');

// authentication
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');

// menu
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

// admin site administration
Route::prefix('admin')->group(function () {
    Route::get('/site-admin', [AdminController::class, 'index'])->name('site-admin');

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

    // resource controller course
    Route::resource('/course', CourseController::class);
    Route::post('/course/getParticipant', [CourseController::class, 'getParticipant'])->name('course.getParticipant');
    Route::post('/course/saveParticipant', [CourseController::class, 'saveParticipant'])->name('course.saveParticipant');

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
});
