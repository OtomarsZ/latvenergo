<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Izveidojam vairākus produktus uzreiz
        Product::create([
            'name' => 'LED Spuldze 10W',
            'description' => 'Energoefektīva A++ klases spuldze mājoklim.',
            'price' => 4.50,
            'quantity' => 50
        ]);

        Product::create([
            'name' => 'Viedais skaitītājs',
            'description' => 'Attālināti nolasāms elektroenerģijas skaitītājs.',
            'price' => 85.00,
            'quantity' => 12
        ]);

        Product::create([
            'name' => 'Saules paneļu komplekts',
            'description' => '3kW sistēma privātmājas jumtam.',
            'price' => 1200.00,
            'quantity' => 3
        ]);
    }
}