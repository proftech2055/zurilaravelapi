<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome', ['title' => "Home"]);
});
Route::get('/register', function () {
    return view('register', ['title' => "Register"]);
});
Route::post('/register', [UserController::class, "create"]);
Route::get('/accounts', [UserController::class, "read"]);
Route::get('/accounts/{id}', [UserController::class, "edit"]);
Route::put('/accounts/{id}', [UserController::class, "update"]);
Route::delete('/accounts/{id}', [UserController::class, "delete"]);
