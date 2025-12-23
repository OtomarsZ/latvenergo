<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    $products = Product::all();
    return view('welcome', compact('products'));
});

// Maršruts pasūtījumu veikšanai (Pirkt pogai)
Route::post('/order', [OrderController::class, 'store']);

// ŠĪ RINDIŅA TRŪKST - Maršruts jaunu produktu pievienošanai
Route::post('/products', [OrderController::class, 'createProduct']);

Route::get('/test-db', function () {
    return Product::all();
});