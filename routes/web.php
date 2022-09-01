<?php

use App\Models\Image;
use Illuminate\Support\Facades\Route;

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
Route::get("/", function () {
    return view("images", [
        "heading" => "Image Gallery",
        "images" => Image::all()
    ]);
});

// Single image
Route::get('/images/{image}', function (Image $image) {
    return view(
        "image",
        [
            "image" => $image
        ]
    );
});

Route::get('/sign-up', function () {
    return view("sign-up");
});

Route::get('/login', function () {
    return view("login");
});

Route::get('/new-image', function () {
    return view("new-image");
});
