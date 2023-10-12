<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\SliderController;
use Illuminate\Support\Facades\Route;

//admin route
Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('profile', [AdminController::class, 'profile'])->name('profile');

Route::post('profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');
Route::post('password/update', [AdminController::class, 'updatePassword'])->name('password.update');


// slider route
Route::resource('slider',SliderController::class);
