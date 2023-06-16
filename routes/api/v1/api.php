<?php

use App\Http\Controllers\api\AdminController;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:api'])->group(function () {
    Route::post('/tokens/create', [AdminController::class, 'createToken'])->name('create_token');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('admins', AdminController::class)->only('show');
        Route::apiResource('admins', AdminController::class)->except('show')
            ->middleware(['abilities:modify']);

        Route::group(['prefix' => 'admins', 'as' => 'admins.', 'middleware' => 'abilities:modify'], function () {
            Route::post('/delete-queue', [AdminController::class, 'queueForDeletion'])->name('queue_for_deletion');
            Route::delete('/batch/{deleteKey}', [AdminController::class, 'deleteAdmins'])->name('delete_admins');
        });

        Route::get('/batch/{batchId}', function (string $batchId) {
            return Bus::findBatch($batchId);
        });
    });
});
