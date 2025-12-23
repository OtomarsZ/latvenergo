<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Šī metode apstrādā PIRKŠANU (poga "Pirkt")
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);

            if ($product->quantity < $request->quantity) {
                return response()->json(['error' => 'Nepietiekams preču skaits noliktavā!'], 400);
            }

            $product->decrement('quantity', $request->quantity);

            $order = Order::create([
                'total_price' => $product->price * $request->quantity
            ]);

            return response()->json([
                'message' => 'Pasūtījums veiksmīgs!',
                'order_id' => $order->id,
                'atlikums' => $product->quantity
            ]);
        });
    }

    // ŠĪ METODE BIJA TRŪKSTOŠĀ - Tā apstrādā jauna produkta PIEVIENOŠANU
    public function createProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        // Izveidojam jaunu ierakstu datubāzē
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        // Pēc saglabāšanas pāradresējam atpakaļ uz sākumlapu
        return redirect('/');
    }
}