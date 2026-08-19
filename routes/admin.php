<?php

use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::view('/styleguide', 'admin.styleguide')->name('styleguide');

Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

Route::get('password', [PasswordController::class, 'edit'])->name('password.edit');
Route::put('password', [PasswordController::class, 'update'])->name('password.update');