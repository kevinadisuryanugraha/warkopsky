<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\StoryController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\EventController;

/*
|--------------------------------------------------------------------------
| Public Routes (with visitor tracking)
|--------------------------------------------------------------------------
*/
Route::middleware(['track-visitor'])->group(function () {
    Route::get('/', [PublicController::class, 'home'])->name('public.home');
    Route::get('/menu', [PublicController::class, 'menu'])->name('public.menu');
    Route::get('/galeri', [PublicController::class, 'gallery'])->name('public.gallery');
    Route::get('/stories', [PublicController::class, 'stories'])->name('public.stories');
    Route::get('/tentang', [PublicController::class, 'about'])->name('public.about');
    Route::get('/kontak', [PublicController::class, 'contact'])->name('public.contact');
    Route::get('/events', [PublicController::class, 'events'])->name('public.events');
});
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Protected Admin Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'prevent-back-history'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // System Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/data', [AnalyticsController::class, 'apiData'])->name('analytics.data');
    Route::post('/analytics/reset', [AnalyticsController::class, 'reset'])->name('analytics.reset');
    
    // CRUD Menu Items & Categories
    Route::get('menu-categories', [MenuController::class, 'categoriesIndex'])->name('menu.categories.index');
    Route::get('menu-categories/create', [MenuController::class, 'categoriesCreate'])->name('menu.categories.create');
    Route::resource('menu', MenuController::class);
    Route::post('menu-category', [MenuController::class, 'storeCategory'])->name('menu.category.store');
    Route::delete('menu-category/{category}', [MenuController::class, 'destroyCategory'])->name('menu.category.destroy');
    
    // CRUD Gallery Items & Categories
    Route::get('gallery-categories', [GalleryController::class, 'categoriesIndex'])->name('gallery.categories.index');
    Route::get('gallery-categories/create', [GalleryController::class, 'categoriesCreate'])->name('gallery.categories.create');
    Route::resource('gallery', GalleryController::class);
    Route::post('gallery-category', [GalleryController::class, 'storeCategory'])->name('gallery.category.store');
    Route::delete('gallery-category/{category}', [GalleryController::class, 'destroyCategory'])->name('gallery.category.destroy');
    
    // Story Moderation
    Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
    Route::patch('/stories/{story}/status', [StoryController::class, 'updateStatus'])->name('stories.updateStatus');
    Route::delete('/stories/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');
    
    // Reservation Management
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::patch('/reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // Events Management
    Route::resource('events', EventController::class);
});
