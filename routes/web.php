<?php

use App\Models\Image;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
Route::get('/images/create', [ImageController::class, "create"])->middleware("auth");

// Show single image
Route::get('/images/{image}', [ImageController::class, "show"]);

// Show image edit form
Route::get('/images/{image}/edit', [ImageController::class, "edit"])->middleware("auth");

// Delete single image
Route::delete('/images/{image}', [ImageController::class, "delete"])->middleware("auth");

// Add new image
Route::post('/images', [ImageController::class, "store"])->middleware("auth");

// Edit existing image
Route::put('/images/{image}', [ImageController::class, "update"])->middleware("auth");

// Show all images 
Route::get("/", [ImageController::class, "index"]);



// Show sign up form
Route::get('/sign-up', [UserController::class, "create"])->middleware("guest");

// Sign in user
Route::post('/users/authenticate', [UserController::class, "authenticate"])->middleware("guest");

// Create new user
Route::post('/users', [UserController::class, "store"])->middleware("guest");

// Show login form
Route::get('/login', [UserController::class, "login"])->name("login")->middleware("guest");

// User logout
Route::post('/logout', [UserController::class, "logout"])->middleware("auth");;
