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

// Show add new image form
Route::get('/images/create', [ImageController::class, "create"]);

// Show single image
Route::get('/images/{image}', [ImageController::class, "show"]);

// Adds new image
Route::post('/images', [ImageController::class, "store"]);

// Show all images 
Route::get("/", [ImageController::class, "index"]);



// // Sign up
// Route::get('/sign-up', function () {
//     return view("sign-up");
// });

// // Login
// Route::get('/login', function () {
//     return view("login");
// });
