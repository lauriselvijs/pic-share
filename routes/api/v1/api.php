<?php

use App\Http\Controllers\api\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware(['throttle:api'])->group(function () {
Route::apiResource('/admins', AdminController::class);
// })
Route::group(['prefix' => 'admins', 'as' => 'admins.'], function () {
    Route::post('/delete-queue', [AdminController::class, 'queueForDeletion'])->name('queue-for-deletion');
    Route::delete('/batch/{deleteKey}', [AdminController::class, 'deleteAdmins'])->name('delete-admins');
});
