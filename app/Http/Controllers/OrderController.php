<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validācija (pārbaudām, vai atsūtīti pareizi dati)
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // 2. Izmantojam transakciju, lai viss notiktu droši
        return DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);

            // 3. Pārbaudām, vai noliktavā pietiek preču
            if ($product->quantity < $request->quantity) {
                return response()->json(['error' => 'Nepietiekams preču skaits noliktavā!'], 400);
            }

            // 4. Samazinām skaitu noliktavā
            $product->decrement('quantity', $request->quantity);

            // 5. Izveidojam pasūtījumu
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
}