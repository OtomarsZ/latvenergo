<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function sākumlapa_ielādējas_veiksmīgi()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Latvenergo Veikals');
    }

    #[Test]
    public function var_pievienot_jaunu_produktu_noliktavā()
    {
        $produktaDati = [
            'name' => 'Saules panelis 400W',
            'description' => 'Efektīvs panelis',
            'price' => 250.00,
            'quantity' => 5
        ];

        $response = $this->post('/products', $produktaDati);

        $this->assertDatabaseHas('products', [
            'name' => 'Saules panelis 400W'
        ]);

        $response->assertStatus(302);
    }
}
