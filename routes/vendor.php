<?php

//vendor route

use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\VendorProductImageGalleryController;
use App\Http\Controllers\Backend\VendorProductVariantController;
use App\Http\Controllers\Backend\VendorProfileController;
use App\Http\Controllers\Backend\VendorShopProfileController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
Route::get('/profile', [VendorProfileController::class, 'index'])->name('profile');
Route::put('/profile', [VendorProfileController::class, 'updateProfile'])->name('profile.update');
Route::post('/profile', [VendorProfileController::class, 'updateProfilePassword'])->name('profile.update.password');

Route::resource('shop-profile', VendorShopProfileController::class);


//vendor product Route
Route::get('get-subcategories', [VendorProductController::class, 'getSubCategories'])->name('product.get-subcategories');
Route::get('get-childcategories', [VendorProductController::class, 'getChildCategories'])->name('product.get-childcategories');
Route::resource('products', VendorProductController::class);

//vendor Product image gallery
Route::resource('product-images-gallery', VendorProductImageGalleryController::class);


//Product Variant route
Route::put('product-variant/change-status', [VendorProductVariantController::class, 'changeStatus'])->name('product-variant.change-status');

Route::resource('product-variant', VendorProductVariantController::class);

//variant-items route
// Route::get('product-variant-item/{productId}/{variantId}', [VariantItemController::class, 'index'])->name('product-variant-item.index');
// Route::get('product-variant-item/create/{productId}/{variantId}', [VariantItemController::class, 'create'])->name('product-variant-item.create');

// Route::get('product-variant-item-edit/{variantItemId}', [VariantItemController::class, 'edit'])->name('product-variant-item.edit');
// Route::delete('product-variant-item-destroy/{variantItemId}', [VariantItemController::class, 'destroy'])->name('product-variant-item.destroy');

// Route::post('product-variant-item/create', [VariantItemController::class, 'store'])->name('product-variant-item.store');
// Route::put('product-variant-item-update/{variantItemId}', [VariantItemController::class, 'update'])->name('product-variant-item.update');
// Route::put('product-variant-item-change-status', [VariantItemController::class, 'changeStatus'])->name('product-variant-item.change-status');
