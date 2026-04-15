<?php

use App\Http\Controllers\AppStatusController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/api/status-check', [AppStatusController::class, 'check'])->name('api.status.check');

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/organization', function () {
    return Inertia::render('Organization');
})->name('organization');

Route::get('/partners', function () {
    return Inertia::render('Partners');
})->name('partners');

Route::get('/berita/{slug}', function (string $slug) {
    return Inertia::render('News/Show', [
        'slug' => $slug,
    ]);
})->name('news.show');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
