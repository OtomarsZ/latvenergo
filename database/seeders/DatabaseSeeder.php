<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Šeit mēs izsaucam izveidoto ProductSeeder
        $this->call([
            ProductSeeder::class,
        ]);
    }
}