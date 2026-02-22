<?php

use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormBuilderController;
use App\Http\Controllers\ProfileController;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Temporary test route for Gemini API (DELETE THIS AFTER TESTING)
Route::get('/test-gemini', function () {
    try {
        $gemini = new GeminiService();
        $form = $gemini->generateForm('Create a simple contact form with name, email, and message fields');
        
        return response()->json([
            'success' => true,
            'message' => 'Gemini API test successful!',
            'form' => $form,
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
});

// Test route for FormBuilderController (DELETE THIS AFTER TESTING)
Route::get('/test-controller', function () {
    $results = [];
    
    // Test 1: Check if controller class exists
    $results['controller_exists'] = class_exists(\App\Http\Controllers\FormBuilderController::class);
    
    // Test 2: Check if Form model exists
    $results['form_model_exists'] = class_exists(\App\Models\Form::class);
    
    // Test 3: Check if GeminiService exists
    $results['gemini_service_exists'] = class_exists(\App\Services\GeminiService::class);
    
    // Test 4: Check if Form::generateSlug() works
    try {
        $slug = \App\Models\Form::generateSlug();
        $results['slug_generation'] = [
            'success' => true,
            'slug' => $slug,
            'length' => strlen($slug)
        ];
    } catch (Exception $e) {
        $results['slug_generation'] = [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
    
    // Test 5: Check routes
    $results['routes'] = [
        'builder_index' => route('builder.index'),
        'builder_generate' => route('builder.generate'),
        'builder_store' => route('builder.store'),
        'builder_clearChat' => route('builder.clearChat'),
    ];
    
    return response()->json([
        'message' => 'FormBuilderController Test Results',
        'results' => $results,
        'all_passed' => $results['controller_exists'] && 
                        $results['form_model_exists'] && 
                        $results['gemini_service_exists'] &&
                        $results['slug_generation']['success']
    ]);
});

// Google OAuth routes
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Form Builder routes
    Route::get('/builder', [FormBuilderController::class, 'index'])->name('builder.index');
    Route::post('/builder/generate', [FormBuilderController::class, 'generate'])
        ->middleware('throttle:ai-requests')
        ->name('builder.generate');
    Route::post('/builder/store', [FormBuilderController::class, 'store'])->name('builder.store');
    Route::post('/builder/clear-chat', [FormBuilderController::class, 'clearChat'])->name('builder.clearChat');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
