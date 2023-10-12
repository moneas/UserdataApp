<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user-list', [UserController::class, 'userList']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/user-search', [UserController::class, 'userSearch'])->name('user.search');

});

Route::get('/countries', [UserController::class, 'countryList']);
Route::post('/register', [UserController::class, 'store']);