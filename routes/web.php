<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('licenses', [LicensesController::class, 'index'])->name('licenses.index');
    Route::get('licenses/create', [LicensesController::class, 'create'])->name('licenses.create');
    Route::post('licenses', [LicensesController::class, 'store'])->name('licenses.store');
    Route::get('licenses/{license}', [LicensesController::class, 'show'])->name('licenses.show');
    Route::get('licenses/{license}/edit', [LicensesController::class, 'edit'])->name('licenses.edit');
    Route::put('licenses/{license}', [LicensesController::class, 'update'])->name('licenses.update');
    Route::delete('licenses/{license}', [LicensesController::class, 'destroy'])->name('licenses.destroy');

    // deactive license
    Route::post('licenses/{license}/deactivate', [LicensesController::class, 'deactivate'])->name('licenses.deactivate');
    // activate license
    Route::post('licenses/{license}/activate', [LicensesController::class, 'activate'])->name('licenses.activate');
    // validate license
    Route::post('licenses/{license}/validate', [LicensesController::class, 'validate'])->name('licenses.validate');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
