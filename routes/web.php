<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/', [UserController::class,'index'])->name('users');
Route::get('user', [UserController::class,'getusers'])->name('users.list');
Route::post('user',[UserController::class,'store'])->name('users.add');
Route::get('user/{userid}',[UserController::class,'show'])->name('users.show');
Route::get('user/{userid}/edit',[UserController::class,'edit'])->name('users.edit');
Route::post('user/{userid}',[UserController::class,'update'])->name('users.update');
Route::delete('user/{userid}',[UserController::class,'destroy'])->name('users.destory');