<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/category/{id}/products', [IndexController::class, 'getCategoryProducts']);

Route::resource('category', CategoryController::class);
Route::resource('product', ProductController::class);
