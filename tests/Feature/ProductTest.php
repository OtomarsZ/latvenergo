<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase; // Šis automātiski iztīra datubāzi pēc katra testa

    /** @test */
    public function sākumlapa_ielādējas_veiksmīgi()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Latvenergo Veikals'); // Pārbauda, vai teksts ir lapā
    }

    /** @test */
    public function var_pievienot_jaunu_produktu_noliktavā()
    {
        $produktaDati = [
            'name' => 'Saules panelis 400W',
            'description' => 'Efektīvs panelis',
            'price' => 250.00,
            'quantity' => 5
        ];

        // Veicam POST pieprasījumu (tāpat kā tava forma welcome lapā)
        $response = $this->post('/products', $produktaDati);

        // Pārbaudām, vai dati tiešām ir datubāzē
        $this->assertDatabaseHas('products', [
            'name' => 'Saules panelis 400W'
        ]);

        // Pārbaudām, vai mūs pārmeta atpakaļ (redirect)
        $response->assertStatus(302);
    }
}
