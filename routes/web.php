<?php

use App\Http\Controllers\AppStatusController;
use App\Http\Controllers\CarouselSlideController;
use App\Http\Controllers\ProfileController;
use App\Models\CarouselSlide;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/api/status-check', [AppStatusController::class, 'check'])->name('api.status.check');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'slides' => CarouselSlide::orderBy('order')->where('is_active', true)->get(),
    ]);
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

Route::get('/downloads', function () {
    return Inertia::render('Services/Downloads');
})->name('downloads');

Route::get('/knowledge-base', function () {
    return Inertia::render('Services/KnowledgeBase');
})->name('knowledge-base');

Route::get('/gallery', function () {
    return Inertia::render('Gallery');
})->name('gallery');

Route::get('/status', function () {
    return Inertia::render('Status/Index');
})->name('status');

Route::prefix('tik-cms')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/homepage', function () {
        return Inertia::render('Admin/Homepage', [
            'slides' => CarouselSlide::orderBy('order')->get(),
        ]);
    })->name('admin.homepage');

    Route::post('/carousel', [CarouselSlideController::class, 'store'])->name('carousel.store');
    Route::post('/carousel/{carouselSlide}', [CarouselSlideController::class, 'update'])->name('carousel.update');
    Route::delete('/carousel/{carouselSlide}', [CarouselSlideController::class, 'destroy'])->name('carousel.destroy');
    Route::patch('/carousel/{carouselSlide}/toggle', [CarouselSlideController::class, 'toggleActive'])->name('carousel.toggle');

    Route::get('/news', function () {
        return Inertia::render('Admin/News');
    })->name('admin.news');

    Route::get('/gallery', function () {
        return Inertia::render('Admin/Gallery');
    })->name('admin.gallery');

    Route::get('/downloads', function () {
        return Inertia::render('Admin/Downloads');
    })->name('admin.downloads');

    Route::get('/knowledge-base', function () {
        return Inertia::render('Admin/KnowledgeBase');
    })->name('admin.knowledge-base');

    Route::get('/organization', function () {
        return Inertia::render('Admin/Organization');
    })->name('admin.organization');

    Route::get('/partners', function () {
        return Inertia::render('Admin/Partners');
    })->name('admin.partners');

    Route::get('/status', function () {
        return Inertia::render('Admin/Status');
    })->name('admin.status');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
