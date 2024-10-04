<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/account', [AccountController::class, 'account'])->name('account');
    Route::patch('/account', [AccountController::class, 'update_account'])->name('update_account');
    Route::get('/subscriptions', [SubscriptionController::class, 'subscriptions'])->name('subscriptions');
    Route::post('/subscriptions', [SubscriptionController::class, 'subscribe'])->name('subscribe');

    Route::middleware('check.subscribed')->group(function () {
        Route::get('/payment-method', [SubscriptionController::class, 'payment_method'])->name('payment_method');
        Route::get('/receipts', [SubscriptionController::class, 'receipts'])->name('receipts');
        Route::get('/cancel-account', [SubscriptionController::class, 'cancel_account'])->name('cancel_account');
        Route::post('/pause-account', [SubscriptionController::class, 'do_pause_account'])->name('do_pause_account');
        Route::post('/terminate-account', [SubscriptionController::class, 'do_terminate_account'])->name('do_terminate_account');

        Route::get('invoices/pdf/{id}', [InvoiceController::class, 'pdf'])->name('invoices.upload_invoice');

        Route::get('invoices/send_to_email/{id}', [InvoiceController::class, 'send_to_email'])->name('invoices.send_to_email');
        Route::post('invoices/send_to_email/{id}', [InvoiceController::class, 'do_send_to_email'])->name('invoices.do_send_to_email');
        Route::resource('invoices', InvoiceController::class);
    });

});

