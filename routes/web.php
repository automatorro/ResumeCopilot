<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

// Pagina publică de landing
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutele protejate (necesită autentificare)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::get('/career-brain', fn () => view('career-brain'))->name('career-brain');
    Route::get('/cv-import', fn () => view('cv-import'))->name('cv-import');
    Route::get('/settings', fn () => view('settings'))->name('settings');
});

Route::post('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch')->middleware('auth');

// Rute profil (folosite de navigarea Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
