<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\EmailVerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

// TODO:
// [] - Create resources for CRUD operations (see https://laravel.com/docs/9.x/controllers#resource-controllers).
// Posts
Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
        Route::delete('/{post}', [PostController::class, 'delete'])->name('delete');
        Route::put('/{post}', [PostController::class, 'update'])->name('update');
        Route::post('/', [PostController::class, 'store'])->name('store');
    });
    Route::get('/{post}', [PostController::class, 'show'])->name('show');
    Route::get('/', [PostController::class, 'index'])->name('index');
});


// Users
Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::get('/{user}/posts', [UserController::class, 'posts'])->middleware('auth')->name('posts');
});



// Authentication
Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/sign-up',  [AuthController::class, 'create'])->name('create');
        Route::post('/sign-up',  [AuthController::class, 'store'])->name('store');
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
    });
    Route::post('/logout',  [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});


// Password reset
Route::group(['prefix' => 'password-reset', 'middleware' => 'guest', 'as' => 'password.'], function () {
    Route::get('/forgot-password',  [PasswordResetController::class, 'request'])->name('request');
    Route::post('/forgot-password',  [PasswordResetController::class, 'email'])->name('email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->name('reset');
    Route::post('/reset-password',  [PasswordResetController::class, 'update'])->name('update');
});

// Email verification
Route::group(['prefix' => 'email-verification', 'middleware' => 'auth', 'as' => 'verification.'], function () {
    Route::get('/verify',  [EmailVerificationController::class, 'notice'])->name('notice');
    Route::get('/verify/{id}/{hash}',  [EmailVerificationController::class, 'verify'])->name('verify');
    Route::post('/notification',  [EmailVerificationController::class, 'send'])->middleware('throttle:6,1')->name('send');
});
