<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use Illuminate\Support\Facades\Route;

//admin route
Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('profile', [AdminController::class, 'profile'])->name('profile');

Route::post('profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');
Route::post('password/update', [AdminController::class, 'updatePassword'])->name('password.update');


// slider route
Route::resource('slider', SliderController::class);

//category route
Route::put('change-status', [CategoryController::class, 'changeStatus'])->name('category.change-status');
Route::resource('category', CategoryController::class);

//sub-category route
// Route::put('change-status', [SubCategoryController::class, 'changeStatus'])->name('category.change-status');
Route::resource('sub-category', SubCategoryController::class);
