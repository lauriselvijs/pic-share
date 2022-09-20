<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

// Images
Route::prefix('images')->group(function () {
    Route::name('images.')->group(function () {
        Route::get('/create', [ImageController::class, 'create'])->middleware('auth')->name('create');
        Route::get('/{image}', [ImageController::class, 'show'])->name('show');;
        Route::get('/{image}/edit', [ImageController::class, 'edit'])->middleware('auth')->name('edit');
        Route::delete('/{image}', [ImageController::class, 'delete'])->middleware('auth')->name('delete');
        Route::put('/{image}', [ImageController::class, 'update'])->middleware('auth')->name('update');
        Route::post('/', [ImageController::class, 'store'])->middleware('auth')->name('update');;
        Route::get('/', [ImageController::class, 'index'])->name('index');;
    });
});

// Images of current auth user
Route::get('/images/user', [ImageController::class, 'userImages'])->middleware('auth');

// Show all images 
Route::get('/', [ImageController::class, 'index']);

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
