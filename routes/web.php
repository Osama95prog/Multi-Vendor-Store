<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\Auth\TwoFactorAuthentcationController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CurrencyConverterController;
use App\Http\Controllers\Front\PaymentsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeWebhooksController;
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

Route::get('/',[HomeController::class,'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/index','DashboardController@index');


Route::get('/products', [ProductsController::class, 'index'])
->name('products.index');

Route::get('/products/{product:slug}', [ProductsController::class, 'show'])
->name('products.show');

Route::resource('cart', CartController::class);

Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
Route::post('checkout', [CheckoutController::class, 'store']);


Route::get('auth/user/2fa', [TwoFactorAuthentcationController::class, 'index'])
->name('front.2fa');

Route::post('currency', [CurrencyConverterController::class, 'store'])
->name('currency.store');


Route::get('orders/{order}/pay', [PaymentsController::class, 'create'])
    ->name('orders.payments.create');


Route::post('orders/{order}/stripe/paymeny-intent', [PaymentsController::class, 'createStripePaymentIntent'])
->name('stripe.paymentIntent.create');

Route::get('orders/{order}/pay/stripe/callback', [PaymentsController::class, 'confirm'])
    ->name('stripe.return');


Route::any('stripe/webhook', [StripeWebhooksController::class, 'handle']);



// require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
