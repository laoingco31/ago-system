<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntryController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\UserController;

// Guest-only pages (Login, Register, Forgot Password)
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

// Protected pages (For logged-in users only)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Entry routes using resource controller (CRUD operations)
    Route::resource('entries', EntryController::class);
    Route::get('entries.print', [EntryController::class, 'printAll'])->name('entries.print');
});

// Authentication Routes
Auth::routes(['verify' => true]);

// User-related routes (only for authenticated users)
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->middleware('auth');

// Individual Entry routes (make sure not to conflict with resource routes)
Route::get('/entries/{id}/details', [EntryController::class, 'details'])->name('entries.details');


Route::middleware(['auth'])->group(function() {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
