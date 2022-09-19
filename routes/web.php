<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
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


// Show add new image form
Route::get('/images/create', [ImageController::class, 'create'])->middleware('auth');

// Images of current auth user
Route::get('/images/user', [ImageController::class, 'userImages'])->middleware('auth');

// Show single image
Route::get('/images/{image}', [ImageController::class, 'show']);

// Show image edit form
Route::get('/images/{image}/edit', [ImageController::class, 'edit'])->middleware('auth');

// Delete single image
Route::delete('/images/{image}', [ImageController::class, 'delete'])->middleware('auth');

// Add new image
Route::post('/images', [ImageController::class, 'store'])->middleware('auth');

// Edit existing image
Route::put('/images/{image}', [ImageController::class, 'update'])->middleware('auth');

// Show all images 
Route::get('/', [ImageController::class, 'index']);



// // Show sign up form
// Route::get('/sign-up', [UserController::class, 'create'])->middleware('guest');

// // Sign in user
// Route::post('/users/authenticate', [UserController::class, 'authenticate'])->middleware('guest');

// // Create new user
// Route::post('/users', [UserController::class, 'store'])->middleware('guest');

// // Show login form
// Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// // User logout
// Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');


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
