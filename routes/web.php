<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormBuilderController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PublicFormController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Public form routes (no auth required)
Route::get('/f/{slug}', [PublicFormController::class, 'show'])->name('public.forms.show');
Route::post('/f/{slug}', [PublicFormController::class, 'submit'])->name('public.forms.submit');
Route::get('/f/{slug}/thank-you', [PublicFormController::class, 'thankYou'])->name('public.forms.thankYou');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Form Builder routes
    Route::get('/builder', [FormBuilderController::class, 'index'])->name('builder.index');
    Route::post('/builder/generate', [FormBuilderController::class, 'generate'])
        ->middleware('throttle:ai-requests')
        ->name('builder.generate');
    Route::post('/builder/store', [FormBuilderController::class, 'store'])->name('builder.store');
    Route::post('/builder/clear-chat', [FormBuilderController::class, 'clearChat'])->name('builder.clearChat');
    
    // Form Management routes
    Route::delete('/forms/{form}', [FormController::class, 'destroy'])->name('forms.destroy');
    Route::patch('/forms/{form}/toggle', [FormController::class, 'toggle'])->name('forms.toggle');
    Route::get('/forms/{form}/submissions', [SubmissionController::class, 'index'])->name('forms.submissions');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
