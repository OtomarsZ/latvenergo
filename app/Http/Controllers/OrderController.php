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
        // Validējam masīvu "items"
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $totalPrice = 0;

                foreach ($request->items as $item) {
                    // lockForUpdate neļauj citiem mainīt šo rindu, kamēr mēs strādājam
                    $product = Product::lockForUpdate()->findOrFail($item['id']);

                    if ($product->quantity < $item['qty']) {
                        // Ja kaut viena prece par maz, metam kļūdu un Transaction visu atceļ
                        throw new \Exception("Prece '{$product->name}' nav pietiekamā daudzumā!");
                    }

                    $product->decrement('quantity', $item['qty']);
                    $totalPrice += $product->price * $item['qty'];
                }

                // Izveidojam pasūtījumu tikai tad, ja visas preces bija pieejamas
                $order = Order::create(['total_price' => $totalPrice]);

                return response()->json([
                    'message' => 'Pasūtījums veiksmīgi noformēts!',
                    'order_id' => $order->id
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function createProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        return redirect('/');
    }
}