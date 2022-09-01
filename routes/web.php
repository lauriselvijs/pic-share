<?php

use App\Models\Image;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

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

// All images 
Route::get("/", [ImageController::class, "index"]);

// Single image
Route::get('/images/{image}', [ImageController::class, "show"]);

// Create new image
Route::get('/new-image', function () {
    return view("new-image");
});

// Sign up
Route::get('/sign-up', function () {
    return view("sign-up");
});

// Login
Route::get('/login', function () {
    return view("login");
});
