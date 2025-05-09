<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Guest Routes (only accessible if NOT logged in)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/', fn () => view('index'))->name('index');
    Route::get('/login', fn () => view('auth.login'))->name('login');

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (only if logged in)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Landing page after login
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Entry CRUD
    Route::resource('entries', EntryController::class);
    Route::get('entries.print', [EntryController::class, 'printAll'])->name('entries.print');
    Route::get('/entries/{id}/details', [EntryController::class, 'details'])->name('entries.details');

    // Proof Images
    Route::get('/proof-images', [EntryController::class, 'showProofImages'])->name('proof.images');
    Route::get('/proofs', [EntryController::class, 'showAllProofs'])->name('entries.proofs');

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

/*
|--------------------------------------------------------------------------
| Laravel Auth Routes (Login, Register, etc.)
|--------------------------------------------------------------------------
*/
Auth::routes(['verify' => true]);
