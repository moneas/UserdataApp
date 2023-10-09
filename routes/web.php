<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
 
Route::get('/', [UserController::class, 'showRegistrationForm']);
Route::get('/register', [UserController::class, 'showRegistrationForm']);
Route::post('/register', [UserController::class, 'store'])->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/user-list', [UserController::class, 'userList'])->name('user.list');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

});
