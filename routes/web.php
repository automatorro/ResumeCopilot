<?php

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

require __DIR__.'/auth.php';
