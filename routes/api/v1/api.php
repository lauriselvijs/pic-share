<?php

use App\Http\Controllers\api\AdminController;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:api'])->group(function () {
    Route::post('admins/login', [AdminController::class, 'login'])->name('admins.login');

    Route::group(['prefix' => 'admins', 'as' => 'admins.', 'middleware' => 'auth:sanctum'], function () {
        Route::get('logout', [AdminController::class, 'logout'])->name('logout');

        Route::get('/batch/{batchId}', function (string $batchId) {
            return Bus::findBatch($batchId);
        });
    });

    Route::group(['prefix' => 'admins', 'as' => 'admins.', 'middleware' => ['auth:sanctum', 'abilities:admin:mass-delete']], function () {
        Route::post('/delete-queue', [AdminController::class, 'queueForDeletion'])->name('queue_for_deletion');
        Route::delete('/batch/{deleteKey}', [AdminController::class, 'deleteAdmins'])->name('delete_admins');
    });



    Route::apiResource('admins', AdminController::class)->middleware(['auth:sanctum', 'abilities:admin:create,admin:update,admin:delete']);
});
