<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Kernel;

// Public routes
Route::get('/', [LaundryController::class, 'dashboard'])->name('dashboard');
Route::resource('laundry', LaundryController::class);
Route::get('/laundry/{laundry}', [LaundryController::class, 'show'])->name('laundry.show');
Route::get('/laundry/{laundry}/gallery', [GalleryController::class, 'index'])->name('gallery.index');



// Authentication routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth'])->group(function () {
    Route::resource('laundry', LaundryController::class)->except(['show']);
    Route::post('/laundry/{laundry}/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::put('/gallery/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::resource('users', UserController::class);
});

// // User routes
// Route::middleware(['auth', 'role:user,admin'])->group(function () {
//     Route::post('/laundry/{laundry}/review', [LaundryController::class, 'storeReview'])->name('laundry.review.store');
// });


// Route::get('/', [LaundryController::class, 'dashboard'])->name('dashboard');

// Route::resource('laundry', LaundryController::class);

// Route::get('/laundry/{laundry}/gallery', [GalleryController::class, 'index'])->name('gallery.index');
// Route::post('/laundry/{laundry}/gallery', [GalleryController::class, 'store'])->name('gallery.store');
// Route::put('/gallery/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
// Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');


// Route::resource('users', UserController::class);


// Route::middleware(['auth'])->group(function () {
//     Route::resource('users', UserController::class);
//     Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
//     Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
// });

// Route::prefix('admin')->group(function () {
//     Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
//     Route::post('/login', [AdminController::class, 'login']);
//     Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth:admin');
//     Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile')->middleware('auth:admin');
//     Route::put('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update')->middleware('auth:admin');
//     Route::put('/change-password', [AdminController::class, 'changePassword'])->name('admin.password.change')->middleware('auth:admin');
//     Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
// });

