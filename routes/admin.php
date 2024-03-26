<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdminVendorProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\FlashSaleController;
use App\Http\Controllers\Backend\PaymentSettingController;
use App\Http\Controllers\Backend\PaypalSettingController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductImageGalleryController;
use App\Http\Controllers\Backend\ProductVariantController;
use App\Http\Controllers\Backend\SellerProductController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\ShippingRuleController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\VariantItemController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

//admin route
Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('profile', [AdminController::class, 'profile'])->name('profile');

Route::post('profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');
Route::post('password/update', [AdminController::class, 'updatePassword'])->name('password.update');


// slider route
Route::resource('slider', SliderController::class);

//category route
Route::put('category/change-status', [CategoryController::class, 'changeStatus'])->name('category.change-status');
Route::resource('category', CategoryController::class);

//sub-category route
Route::put('sub-category/change-status', [SubCategoryController::class, 'changeStatus'])->name('sub-category.change-status');
Route::resource('sub-category', SubCategoryController::class);


//child-category route
Route::get('get-subcategories', [ChildCategoryController::class, 'getSubCategories'])->name('get-subcategories');
Route::put('child-category/change-status', [ChildCategoryController::class, 'changeStatus'])->name('child-category.change-status');
Route::resource('child-category', ChildCategoryController::class);


//sub-category route
Route::put('brand/change-status', [BrandController::class, 'changeStatus'])->name('brand.change-status');
Route::resource('brand', BrandController::class);

//Vendor Profile route
Route::resource('vendor-profile', AdminVendorProfileController::class);

//Product route
Route::get('get-subcategories', [ProductController::class, 'getSubCategories'])->name('product.get-subcategories');
Route::get('get-childcategories', [ProductController::class, 'getChildCategories'])->name('product.get-childcategories');
Route::put('product/change-status', [ProductController::class, 'changeStatus'])->name('product.change-status');

Route::resource('products', ProductController::class);
Route::resource('product-images-gallery', ProductImageGalleryController::class);

//Product Variant route
Route::put('product-variant/change-status', [ProductVariantController::class, 'changeStatus'])->name('product-variant.change-status');

Route::resource('product-variant', ProductVariantController::class);

//variant-items route
Route::get('product-variant-item/{productId}/{variantId}', [VariantItemController::class, 'index'])->name('product-variant-item.index');
Route::get('product-variant-item/create/{productId}/{variantId}', [VariantItemController::class, 'create'])->name('product-variant-item.create');

Route::get('product-variant-item-edit/{variantItemId}', [VariantItemController::class, 'edit'])->name('product-variant-item.edit');
Route::delete('product-variant-item-destroy/{variantItemId}', [VariantItemController::class, 'destroy'])->name('product-variant-item.destroy');

Route::post('product-variant-item/create', [VariantItemController::class, 'store'])->name('product-variant-item.store');
Route::put('product-variant-item-update/{variantItemId}', [VariantItemController::class, 'update'])->name('product-variant-item.update');
Route::put('product-variant-item-change-status', [VariantItemController::class, 'changeStatus'])->name('product-variant-item.change-status');

//Seller Product route
Route::get('seller-products', [SellerProductController::class, 'index'])->name('seller-products.index');
Route::get('pending-seller-products', [SellerProductController::class, 'PendingSellerProduct'])->name('pending-seller-products.PendingSellerProduct');
Route::put('seller-products/change-approve', [SellerProductController::class, 'ChangeApprove'])->name('seller-product.change-approved');

//Flash sale route
Route::get('flash-sale', [FlashSaleController::class, 'index'])->name('flash-sale.index');
Route::put('flash-sale', [FlashSaleController::class, 'Update'])->name('flash-sale.update');
Route::post('flash-sale/add-product', [FlashSaleController::class, 'AddProduct'])->name('flash-sale.add-product');
Route::put('flash-sale/change-show-at-home', [FlashSaleController::class, 'ChangeShowAtHome'])->name('flash-sale.change-show-at-home');

Route::put('flash-sale/change-status', [FlashSaleController::class, 'ChangeStatus'])->name('flash-sale.change-status');
Route::delete('flash-sale/{id}', [FlashSaleController::class, 'destroy'])->name('flash-sale.destroy');


//setting routes
Route::get('setting', [SettingController::class, 'index'])->name('settings.index');
Route::put('setting', [SettingController::class, 'Update'])->name('settings.update');


//coupon routes
Route::put('coupons/change-status', [CouponController::class, 'changeStatus'])->name('coupons.change-status');
Route::resource('coupons', CouponController::class);


//shipping-rule routes
Route::put('shipping-rule/change-status', [ShippingRuleController::class, 'changeStatus'])->name('shipping-rule.change-status');
Route::resource('shipping-rule', ShippingRuleController::class);

// payment settings routes
Route::get("payment-settings", [PaymentSettingController::class, "index"])->name('payment-settings.index');
Route::resource("paypal-setting", PaypalSettingController::class);
