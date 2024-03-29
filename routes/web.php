<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Frontend\AddressController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Frontend\FrontendProductController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('admin/login', [AdminController::class, "login"])->name('admin.login');





require __DIR__ . '/auth.php';


Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [UserProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile', [UserProfileController::class, 'updateProfilePassword'])->name('profile.update.password');

    Route::resource("/address", AddressController::class);

    Route::get("/check-out", [CheckoutController::class, "index"])->name("check-out");
    Route::post("/create-address", [CheckoutController::class, "createUserAdress"])->name("create-address");
    Route::post("/check-out/form-submit", [CheckoutController::class, "checkoutFormSubmit"])->name("checkout.form-submit");

    //payment route
    Route::get("payment", [PaymentController::class, "index"])->name("payment");
    Route::get("payment-success", [PaymentController::class, "paymentSuccess"])->name("payment.success");

    // route paypal
    Route::get("paypal/payment", [PaymentController::class, "payWithPaypal"])->name("paypal.payment");
    Route::get("paypal/success", [PaymentController::class, "paypalSuccess"])->name("paypal.success");
    Route::get("paypal/cancel", [PaymentController::class, "paypalCancel"])->name("paypal.cancel");

    //route stripe
    Route::post("stripe/payment", [PaymentController::class, "payWithStripe"])->name("stripe.payment");

    // razorpay routes
    Route::post("razorpay/payment", [PaymentController::class, "payWithRazorpay"])->name("razorpay.payment");


});


// flashsale route
Route::get('flash-sale', [FlashSaleController::class, "index"])->name('flash-sale');

// frontend product route
Route::get('product-detail/{slug}', [FrontendProductController::class, "index"])->name('product-detail');

// cart route
Route::post("add-to-cart", [CartController::class, "addToCart"])->name("add-to-cart");
Route::get("cart-details", [CartController::class, "cartViewDetail"])->name("cart-details");
Route::post("update-product-quantity", [CartController::class, "updateProductQuantity"])->name("update-product-quantity");
Route::delete("clear-cart", [CartController::class, "cartClear"])->name("clear-cart");
Route::get("cart-delete-product/{rowId}", [CartController::class, "cartDeleteProduct"])->name("cart-delete-product");
Route::get("cart-count", [CartController::class, "updateCartCount"])->name("cart-count");
Route::get("mini-cart-amount", [CartController::class, "miniCartAmount"])->name("mini-cart-amount");
Route::get("cart-content", [CartController::class, "getCartContent"])->name("cart-content");
Route::post("mini-cart-remove", [CartController::class, "miniCartRemove"])->name("mini-cart-remove");
Route::post("apply-coupon", [CartController::class, "applyCoupon"])->name("apply-coupon");
Route::get("coupon-calculate", [CartController::class, "couponCalculate"])->name("coupon-calculate");




