<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // 1. PASŪTĪJUMA APSTRĀDE
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $totalPrice = 0;

                foreach ($request->items as $item) {
                    $product = Product::lockForUpdate()->findOrFail($item['id']);

                    if ($product->quantity < $item['qty']) {
                        throw new \Exception("Prece '{$product->name}' nav pietiekamā daudzumā!");
                    }

                    $product->decrement('quantity', $item['qty']);
                    $totalPrice += $product->price * $item['qty'];
                }

                $order = Order::create(['total_price' => $totalPrice]);

                return response()->json([
                    'message' => 'Pasūtījums veiksmīgs!',
                    'order_id' => $order->id
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // 2. PRODUKTU SARAKSTS PASŪTĪJUMIEM (ja lieto atsevišķu lapu)
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('orders', compact('orders'));
    }

    // 3. JAUNA PRODUKTA PIEVIENOŠANA (Ar aprakstu)
    public function createProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        return redirect('/');
    }
}