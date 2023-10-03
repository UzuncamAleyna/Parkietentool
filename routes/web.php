<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\EigendomsbewijsController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RingsController;
use App\Http\Controllers\RingTypesController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\WebHookController;
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


// Route voor visitors
Route::get('/', [RingTypesController::class, 'welcome'])->name('welcome');

// Route dashboard
Route::get('/dashboard', [RingTypesController::class, 'home']
)->middleware(['auth', 'verified'])->name('dashboard');

// Routes voor bestellen van ringen
Route::get('/order', [RingTypesController::class, 'index']
)->middleware(['auth', 'verified'])->name('order');

Route::get('/order/{slug}', [RingTypesController::class, 'detail']
)->middleware(['auth', 'verified'])->name('order.detail');

// Route bestelgeschiedenis
Route::get('/order-history', [OrderHistoryController::class, 'index'])->middleware(['auth', 'verified'])->name('order-history');

//Routes shopping cart
Route::get('/shopping-cart', [ShoppingCartController::class, 'viewCart'])->name('shopping-cart');

Route::delete('/shopping-cart/remove/{itemId}', [ShoppingCartController::class, 'removeFromCart'])->name('shopping-cart.remove');

Route::post('/shopping-cart/store', [ShoppingCartController::class, 'store'])->name('shopping-cart.store');

//Routes checkout
Route::post('/shopping-cart/checkout', [CheckoutController::class, 'checkout'])->name('shopping-cart.checkout');

Route::get('/checkout/success', function () {
    return view('checkoutSuccess');
})->middleware(['auth'])->name('checkout.success');

Route::post('/webhooks/mollie', [WebHookController::class, 'handle'])->name('webhooks.mollie');

//Route profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route voor betalen van lidgeld
Route::get('/profile/membershipfee', [MembershipController::class, 'payMembershipFee'])->name('profile.membershipfee');

//Routes Eigendomsbewijzen
Route::post('/eigendomsbewijs', [EigendomsbewijsController::class, 'index'])->name('eigendomsbewijs');

Route::post('/eigendomsbewijs/pdf', [EigendomsbewijsController::class, 'genereerPDf'])->name('eigendomsbewijs.genereerPDf');

require __DIR__.'/auth.php';

// Route admin
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

// Route voor het exporteren naar excel (enkel voor admin)
Route::get('/export-orders', [OrderHistoryController::class, 'export'])->name('export.orders');