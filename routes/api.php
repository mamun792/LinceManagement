<?php

use App\Http\Controllers\Admin\LicensesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::middleware(['throttle:60,1', 'verify_license_key'])
    ->group(function () {
        Route::post('/licenses/validate', [LicensesController::class, 'validate'])->name('licenses.validate');
    });
