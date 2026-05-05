<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\SocialLinkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('landing');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Portfolio Resources
    Route::resource('skills', SkillController::class);
    Route::resource('experiences', ExperienceController::class);
    Route::resource('education', EducationController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('social-links', SocialLinkController::class);

    // Admin Panel
    Route::middleware('role:Admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    });

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Chatbot
    Route::post('/chatbot/chat', [ChatbotController::class, 'chat'])->name('chatbot.chat');
});

require __DIR__.'/auth.php';

// Public profile route must be last to avoid route collisions
Route::get('/{slug}', [ProfileController::class, 'show'])
    ->name('profile.public')
    ->where('slug', '[A-Za-z0-9\-]+');
