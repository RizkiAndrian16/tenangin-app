<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PssAssessmentController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\RuleBasedRuleController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('landing.index');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

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
    // RECOMMENDATIONS
    // ======================================
    Route::get('/recommendations/{pssAssessment}', [RecommendationController::class, 'index'])->name('recommendations.index');
    Route::post('/recommendations/{pssAssessment}/preferences', [RecommendationController::class, 'processPreferences'])->name('recommendations.preferences');
    Route::get('/recommendations/{pssAssessment}/final', [RecommendationController::class, 'generateFinalRecommendation'])->name('recommendations.final');
    Route::get('/recommendations-history', [RecommendationController::class, 'history'])->name('recommendations.history');
    Route::get('/recommendations/history/{recommendation}/detail', [RecommendationController::class, 'showHistory'])->name('recommendations.history.show');
    Route::delete('/recommendations/bulk-destroy', [RecommendationController::class, 'bulkDestroy'])->name('recommendations.bulk-destroy');

    // ======================================
    // FEEDBACK & MODE FOKUS
    // ======================================
    Route::get('/feedbacks/{recommendationItem}/focus', [FeedbackController::class, 'focus'])->name('feedbacks.focus');
    Route::post('/feedbacks/{recommendationItem}', [FeedbackController::class, 'store'])->name('feedbacks.store');
    Route::get('/feedbacks/create/{recommendationItem}', [FeedbackController::class, 'create'])->name('feedbacks.create');
    Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
    Route::get('/feedbacks/detail/{feedback}', [FeedbackController::class, 'show'])->name('feedbacks.show');
    Route::delete('/feedbacks/bulk-destroy', [FeedbackController::class, 'bulkDestroy'])->name('feedbacks.bulk-destroy');
    Route::delete('/feedbacks/{feedback}', [FeedbackController::class, 'destroy'])->name('feedbacks.destroy');


    // ==========================================================
    // AREA KHUSUS ADMIN (USERS, ACTIVITIES, RULE BASED RULES)
    // ==========================================================
    Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {

        // MANAJEMEN PENGGUNA
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/bulk-destroy', [UserController::class, 'bulkDestroy'])->name('users.bulk-destroy');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // ACTIVITY (KATALOG AKTIVITAS RELAKSASI)
        Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
        Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
        Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
        // Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
        Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
        Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
        Route::delete('/activities', [ActivityController::class, 'bulkDestroy'])->name('activities.bulk-destroy');
        Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');

        // ATURAN RULE BASED RULES
        Route::get('/rule-based-rules', [RuleBasedRuleController::class, 'index'])->name('rule-based-rules.index');
        Route::get('/rule-based-rules/create', [RuleBasedRuleController::class, 'create'])->name('rule-based-rules.create');
        Route::post('/rule-based-rules', [RuleBasedRuleController::class, 'store'])->name('rule-based-rules.store');
        Route::get('/rule-based-rules/{ruleBasedRule}/edit', [RuleBasedRuleController::class, 'edit'])->name('rule-based-rules.edit');
        Route::put('/rule-based-rules/{ruleBasedRule}', [RuleBasedRuleController::class, 'update'])->name('rule-based-rules.update');
        Route::delete('/rule-based-rules', [RuleBasedRuleController::class, 'bulkDestroy'])->name('rule-based-rules.bulk-destroy');
        Route::delete('/rule-based-rules/{ruleBasedRule}', [RuleBasedRuleController::class, 'destroy'])->name('rule-based-rules.destroy');
    });
});

require __DIR__ . '/auth.php';
