<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // Šī rindiņa ir obligāta!

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pievienojam pirmo produktu
        Product::create([
            'name' => 'Saules paneļu komplekts',
            'price' => 1200.50,
            'quantity' => 10
        ]);

        // Pievienojam otro produktu
        Product::create([
            'name' => 'Viedais skaitītājs',
            'price' => 85.00,
            'quantity' => 50
        ]);
    }
}