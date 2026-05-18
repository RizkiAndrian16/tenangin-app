<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PssAssessmentController;
use App\Http\Controllers\ActivityController;

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
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/university', [ProfileController::class, 'updateUniversity'])->name('profile.university.update');
    Route::put('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');

    // ======================================
    // PSS ASSESSMENTS
    // ======================================
    Route::get('/pss-assessments', [PssAssessmentController::class, 'index'])->name('pss-assessments.index');
    Route::get('/pss-assessments/create', [PssAssessmentController::class, 'create'])->name('pss-assessments.create');
    Route::post('/pss-assessments', [PssAssessmentController::class, 'store'])->name('pss-assessments.store');
    Route::get('/pss-assessments/{pssAssessment}', [PssAssessmentController::class, 'show'])->name('pss-assessments.show');
    Route::delete('/pss-assessments', [PssAssessmentController::class, 'bulkDestroy'])->name('pss-assessments.bulk-destroy');
    Route::delete('/pss-assessments/{pssAssessment}', [PssAssessmentController::class, 'destroy'])->name('pss-assessments.destroy');

    // ======================================
    // Activity (Katalog Aktivitas Relaksasi)
    // ======================================
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    // Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
    Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    Route::delete('/activities', [ActivityController::class, 'bulkDestroy'])->name('activities.bulk-destroy');
    Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');
});

require __DIR__ . '/auth.php';
