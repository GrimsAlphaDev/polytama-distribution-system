<?php

use App\Http\Controllers\AuthentificationController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('portal.index');
    })->name('landing-page');
    Route::get('/login', [AuthentificationController::class, 'login'])->name('login');
});