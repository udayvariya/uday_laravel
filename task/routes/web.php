<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

route::view('register', 'register')->name('register');

route::post('registerSave', [UserController::class, 'register'])->name('registerSave');

route::view('login', 'login')->name('login');
route::view('verification', 'verification')->name('verification');


route::post('loginMatch', [UserController::class, 'login'])->name('loginMatch');
route::post('verifyMatch', [UserController::class, 'verifyMatch'])->name('verifyMatch');

route::get('dashboard', [UserController::class, 'dashboardPage'])->name('dashboard');

route::get('dashboard/inner', [UserController::class, 'innerPage'])->name('inner');

route::get('logout', [UserController::class, 'logout'])->name('logout');
