<?php

use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Prologue\Alerts\Facades\Alert;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('portal.index');
    })->name('landing-page');

    Route::get('/login', [AuthentificationController::class, 'login'])->name('login');

    Route::post('/signIn', [AuthentificationController::class, 'signIn'])->name('signIn');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/checkRoles', [AuthentificationController::class, 'checkRoles'])->name('checkRoles');
    Route::get('/logout', [AuthentificationController::class, 'logout'])->name('logout');
});

Route::group([
    'middleware' => 'auth', 'role:marketing'
], function () {
    Route::get('/marketing', function () {
        return view('marketing.dashboard.index');
    })->name('marketing');

    Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
    Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/customer/insert', [CustomerController::class, 'insert'])->name('customer.insert');
    Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
    
    Route::get('/order', [OrderController::class, 'index'])->name('order');
    Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order/insert', [OrderController::class, 'store'])->name('order.insert');
    Route::get('/order/show/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::get('/order/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
    Route::put('/order/update/{id}', [OrderController::class, 'update'])->name('order.update');
    Route::delete('/order/delete/{id}', [OrderController::class, 'destroy'])->name('order.delete');
});
