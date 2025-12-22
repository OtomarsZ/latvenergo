<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product; // ŠĪ RINDIŅA IR OBLIGĀTA!

Route::get('/', function () {
    return view('welcome');
});

// Šis maršruts ļaus mums redzēt datubāzes saturu pārlūkā
Route::get('/test-db', function () {
    return Product::all();
});

use App\Http\Controllers\OrderController;

Route::post('/order', [OrderController::class, 'store']);