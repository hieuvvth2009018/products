<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ShoppingCartController;
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
Route::get('create',[ProductsController::class,'create']);
Route::post('create',[ProductsController::class,'store']);
Route::get('list',[ProductsController::class,'index']);
Route::get('add',[ShoppingCartController::class,'add']);
Route::get('show',[ShoppingCartController::class,'show']);
Route::get('remove',[ShoppingCartController::class,'remove']);
