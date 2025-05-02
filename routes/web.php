<?php

use App\Http\Controllers\Admin\LicensesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('licenses.index');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('licenses', [LicensesController::class, 'index'])->name('licenses.index');
    Route::get('licenses/create', [LicensesController::class, 'create'])->name('licenses.create');
    Route::post('licenses', [LicensesController::class, 'store'])->name('licenses.store');
    Route::get('licenses/{license}', [LicensesController::class, 'show'])->name('licenses.show');
    Route::get('licenses/{license}/edit', [LicensesController::class, 'edit'])->name('licenses.edit');
    Route::put('licenses/{license}', [LicensesController::class, 'update'])->name('licenses.update');
    Route::delete('licenses/{license}', [LicensesController::class, 'destroy'])->name('licenses.destroy');

    // projects.index
    Route::get('projects', function () {
        return view('admin.projects.index');
    })->name('projects.index');

    // projects.create
    Route::get('projects/create', function () {
        return view('admin.projects.create');
    })->name('projects.create');

    // projects.show
    Route::get('projects/{project}', function ($project) {
        return view('admin.projects.show', compact('project'));
    })->name('projects.show');

    // projects.edit
    Route::get('projects/{project}/edit', function ($project) {
        return view('admin.projects.edit', compact('project'));
    })->name('projects.edit');
    // projects.update
    Route::put('projects/{project}', function ($project) {
        // Logic to update the project
        return redirect()->route('admin.projects.index');
    })->name('projects.update');

    // projects.destroy
    Route::delete('projects/{project}', function ($project) {
        // Logic to delete the project
        return redirect()->route('admin.projects.index');
    })->name('projects.destroy');
    // projects.store
    Route::post('projects', function () {
        // Logic to store the project
        return redirect()->route('admin.projects.index');
    })->name('projects.store');
});
