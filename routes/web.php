<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PasswordResetController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Images
Route::prefix('posts')->group(function () {
    Route::name('posts.')->group(function () {
        Route::get('/create', [PostController::class, 'create'])->middleware('auth')->name('create');
        Route::get('/{post}', [PostController::class, 'show'])->name('show');;
        Route::get('/{post}/edit', [PostController::class, 'edit'])->middleware('auth')->name('edit');
        Route::delete('/{post}', [PostController::class, 'delete'])->middleware('auth')->name('delete');
        Route::put('/{post}', [PostController::class, 'update'])->middleware('auth')->name('update');
        Route::post('/', [PostController::class, 'store'])->middleware('auth')->name('update');;
        Route::get('/', [PostController::class, 'index'])->name('index');;
    });
});

// TODO:
// [] - move to user controller users/{user}/posts
// Post of current auth user
Route::get('/posts/user', [ImageController::class, 'userPosts'])->middleware('auth');

// Authentication
Route::prefix('auth')->group(function () {
    Route::name('auth.')->group(function () {
        Route::get('/sign-up',  [AuthController::class, 'create'])->middleware('guest')->name('create');
        Route::post('/sign-up',  [AuthController::class, 'store'])->middleware('guest')->name('store');
        Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
        Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest')->name('authenticate');
        Route::post('/logout',  [AuthController::class, 'logout'])->middleware('auth')->name('logout');
    });
});

// Password reset
Route::prefix('password-reset')->group(function () {
    Route::name('password.')->group(function () {
        Route::get('/forgot-password',  [PasswordResetController::class, 'request'])->middleware('guest')->name('request');
        Route::post('/forgot-password',  [PasswordResetController::class, 'email'])->middleware('guest')->name('email');
        Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->middleware('guest')->name('reset');
        Route::post('/reset-password',  [PasswordResetController::class, 'update'])->middleware('guest')->name('update');
    });
});
