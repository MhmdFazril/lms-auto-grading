<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
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

// site administration
Route::get('/admin/site-admin', [AdminController::class, 'index'])->name('site-admin');

Route::get('/admin/addTeacher', [AdminController::class, 'addTeacher'])->name('addTeacher');
Route::get('/admin/addStudent', [AdminController::class, 'addStudent'])->name('addStudent');

Route::get('/admin/editTeacher/{user:nip}', [AdminController::class, 'editTeacher'])->name('editTeacher');
Route::get('/admin/editStudent/{user:nisn}', [AdminController::class, 'editStudent'])->name('editStudent');

Route::post('/admin/addTeacher', [AdminController::class, 'createTeacher'])->name('insertTeacher');
Route::post('/admin/addStudent', [AdminController::class, 'createStudent'])->name('insertStudent');

Route::post('/admin/editTeacher', [AdminController::class, 'updateTeacher'])->name('updateTeacher');
Route::post('/admin/editStudent', [AdminController::class, 'updateStudent'])->name('updateStudent');

Route::get('/admin/userListing', [AdminController::class, 'userListing'])->name('userListing');
