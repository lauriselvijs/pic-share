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
Route::get('/images/{id}', function ($id) {
    return view(
        "image",
        [
            "image" => Image::find($id)
        ]
    );
});
