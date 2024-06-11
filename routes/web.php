<?php

use App\Http\Controllers\AuthentificationController;
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
        return 'Berhasil';
    })->name('marketing');
});
