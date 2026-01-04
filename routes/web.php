<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComplaintController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Complaints (ikut ERD)
    |--------------------------------------------------------------------------
    */

    // BUYER: tengok complaint sendiri
    Route::get('/my-complaints', [ComplaintController::class, 'buyerIndex'])
        ->name('complaints.buyer');

    // SELLER / ADMIN: tengok complaint berkaitan (seller dia sahaja, admin semua)
    Route::get('/complaints', [ComplaintController::class, 'index'])
        ->name('complaints.index');

    // ✅ BUYER: create complaint form (MESTI letak sebelum /complaints/{complaint})
    Route::get('/complaints/create', [ComplaintController::class, 'create'])
        ->name('complaints.create');

    // ✅ BUYER: submit complaint
    Route::post('/complaints', [ComplaintController::class, 'store'])
        ->name('complaints.store');

    // ✅ View satu complaint (letak bawah + lock to number supaya "create" tak masuk sini)
    Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])
        ->whereNumber('complaint')
        ->name('complaints.show');

    // ✅ Hantar message dalam complaint
    Route::post('/complaints/{complaint}/messages', [ComplaintController::class, 'storeMessage'])
        ->whereNumber('complaint')
        ->name('complaints.messages.store');
});

require __DIR__.'/auth.php';



