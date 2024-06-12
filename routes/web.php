<?php

use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\CustomerController;
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
    ROute::delete('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
    
});
