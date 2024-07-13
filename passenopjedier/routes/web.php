<?php

use App\Http\Controllers\PetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HouseImageController;
use App\Http\Controllers\SittingRequestController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth', 'blocked')->group(function () {
    Route::get('/dashboard', [SittingRequestController::class, 'showDashboard'])->name('dashboard');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/{user}', [HouseImageController::class, 'store'])->name('house-images.store');
    Route::get('/profile/{user}', [SittingRequestController::class, 'showUser'])->name('profile.show');

    Route::get('/profile/{user}/reviews', [ReviewController::class, 'show'])->name('reviews.show');

    Route::delete('/house-images/{houseImage}', [HouseImageController::class, 'destroy'])->name('house-images.destroy');
   
    Route::get('/sitting-requests', [SittingRequestController::class, 'index'])->name('sitting-requests.index');
    Route::post('/sitting-requests', [SittingRequestController::class, 'store'])->name('sitting-requests.store');

    Route::post('/sitting-requests/accept/{id}', [SittingRequestController::class, 'accept'])->name('sitting-requests.accept');
    Route::post('/sitting-requests/decline/{id}', [SittingRequestController::class, 'decline'])->name('sitting-requests.decline');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::delete('/sitting-requests/delete/{id}', [SittingRequestController::class, 'destroy'])->name('sitting-requests.destroy');
    Route::patch('/profile/{user}/block', [ProfileController::class, 'block'])->name('user.block');
    Route::patch('/profile/{user}/unblock', [ProfileController::class, 'unblock'])->name('user.unblock');
});

Route::resource('pets', PetController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy', 'show'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
