<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // 1. PASŪTĪJUMA APSTRĀDE (AR PREČU DETAĻĀM)
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
                $orderItemsData = [];

                // 1. Cilpa cauri precēm, lai pārbaudītu atlikumu un aprēķinātu cenu
                foreach ($request->items as $item) {
                    $product = Product::lockForUpdate()->findOrFail($item['id']);

                    if ($product->quantity < $item['qty']) {
                        throw new \Exception("Prece '{$product->name}' nav pietiekamā daudzumā!");
                    }

                    // Samazinām atlikumu noliktavā
                    $product->decrement('quantity', $item['qty']);
                    
                    $lineTotal = $product->price * $item['qty'];
                    $totalPrice += $lineTotal;

                    // Sagatavojam datus ierakstam order_items tabulā
                    $orderItemsData[] = [
                        'product_id' => $product->id,
                        'quantity'   => $item['qty'],
                        'price'      => $product->price, // Saglabājam cenu, kāda tā bija pirkuma brīdī
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // 2. Izveidojam galveno pasūtījumu
                $order = Order::create(['total_price' => $totalPrice]);

                // 3. Pievienojam pasūtījuma ID katrai precei un ierakstām datubāzē
                foreach ($orderItemsData as &$data) {
                    $data['order_id'] = $order->id;
                }
                
                // Ievietojam visas preces vienā piegājienā
                DB::table('order_items')->insert($orderItemsData);

                return response()->json([
                    'message' => 'Pasūtījums veiksmīgs!',
                    'order_id' => $order->id
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // 2. PRODUKTU SARAKSTS PASŪTĪJUMIEM
    public function index()
    {
        // Ielādējam pasūtījumus kopā ar to precēm (lai nebūtu 404 vai tukšums)
        $orders = Order::with('products')->orderBy('created_at', 'desc')->get();
        return view('orders', compact('orders'));
    }

    // 3. JAUNA PRODUKTA PIEVIENOŠANA
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