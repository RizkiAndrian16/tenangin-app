<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PssAssessmentController;

Route::get('/', function () {
    return view('landing.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // ======================================
    // PROFILE
    // ======================================

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ======================================
    // PSS ASSESSMENTS
    // ======================================

    Route::get('/pss-assessments', [PssAssessmentController::class, 'index'])->name('pss-assessments.index');

    Route::get('/pss-assessments/create', [PssAssessmentController::class, 'create'])->name('pss-assessments.create');

    Route::post('/pss-assessments', [PssAssessmentController::class, 'store'])->name('pss-assessments.store');

    Route::get('/pss-assessments/{pssAssessment}', [PssAssessmentController::class, 'show'])->name('pss-assessments.show');

    Route::delete('/pss-assessments', [PssAssessmentController::class, 'bulkDestroy'])->name('pss-assessments.bulk-destroy');

    Route::delete('/pss-assessments/{pssAssessment}', [PssAssessmentController::class, 'destroy'])->name('pss-assessments.destroy');
});

require __DIR__ . '/auth.php';
