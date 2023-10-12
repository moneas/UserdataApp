<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
 
Route::get('/', [PageController::class, 'showRegistrationForm']);
Route::get('/register', [PageController::class, 'showRegistrationForm']);
Route::get('/user-list', [PageController::class, 'userList'])->name('user.list');
