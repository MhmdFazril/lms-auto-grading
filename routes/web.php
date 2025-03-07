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
Route::get('/site-admin', [AdminController::class, 'index'])->name('site-admin');

Route::get('/addTeacher', [AdminController::class, 'addTeacher'])->name('addTeacher');
Route::get('/addStudent', [AdminController::class, 'addStudent'])->name('addStudent');
Route::post('/adduser', [AdminController::class, 'insertUser'])->name('insertUser');
