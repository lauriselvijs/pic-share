<?php

use App\Http\Controllers\api\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware(['throttle:api'])->group(function () {
Route::apiResource('/admins', AdminController::class);
// })
