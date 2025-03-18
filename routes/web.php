<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LogosController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\MclassController;
use App\Http\Controllers\SchoolController;
use App\Models\Academic_Year;
use Illuminate\Support\Facades\Route;
use PhpParser\Builder\ClassConst;
use Psy\Command\ListCommand\ClassConstantEnumerator;
use Psy\TabCompletion\AutoCompleter;

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
});
