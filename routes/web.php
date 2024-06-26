<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ArmadaController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\OrderRequestController;
use App\Http\Controllers\AuthentificationController;

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
    'middleware' => ['auth', 'marketing']
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
    
    Route::group([
        'middleware' => ['auth', 'transporter'] 
    ], function () {
    Route::get('/transporter', function () {
        return view('transporter.dashboard.index');
    })->name('transporter');

    Route::get('/armada', [ArmadaController::class, 'index'])->name('armada');
    Route::get('/armada/create' , [ArmadaController::class, 'create'])->name('armada.create');
    Route::post('/armada/insert', [ArmadaController::class, 'store'])->name('armada.insert');
    Route::get('/armada/edit/{id}', [ArmadaController::class, 'edit'])->name('armada.edit');
    Route::put('/armada/update/{id}', [ArmadaController::class, 'update'])->name('armada.update');
    Route::delete('/armada/delete/{id}', [ArmadaController::class, 'destroy'])->name('armada.delete');

    Route::get('/order-request', [OrderRequestController::class, 'index'])->name('order-request');
    Route::get('/order-request/show/{id}', [OrderRequestController::class, 'show'])->name('order-request.show');
    Route::post('/order-request/accept/{id}', [OrderRequestController::class, 'accept'])->name('order-request.accept');
    Route::post('/order-request/reject/{id}', [OrderRequestController::class, 'reject'])->name('order-request.reject');
});


Route::group([
    'middleware' => ['auth', 'driver']
], function () {

    Route::get('/driver', [ShipmentController::class, 'dashboard'])->name('driver');

    Route::get('/driver/shipment', [ShipmentController::class, 'index'])->name('driver.shipment');
    Route::post('/driver/updateStatusDriver/{id}', [ShipmentController::class , 'updateStatusDriver'])->name('driver.updateStatusDriver');
    Route::post('/updateStatusOrder/{id}', [ShipmentController::class, 'updateStatus'])->name('updateStatusOrder');

});