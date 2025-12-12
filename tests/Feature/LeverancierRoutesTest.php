<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeverancierRoutesTest extends TestCase
{
    /**
     * Test leveranciers index route returns view
     */
    public function test_leveranciers_index_returns_view(): void
    {
        $response = $this->get('/leveranciers');

        $response->assertStatus(200);
        $response->assertViewIs('leveranciers.index');
    }

    /**
     * Test leveranciers products route returns view
     */
    public function test_leveranciers_products_returns_view(): void
    {
        // Test with valid ID
        $response = $this->get('/leveranciers/1/products');

        $response->assertStatus(200);
    }

    /**
     * Test home page displays link to leveranciers
     */
    public function test_homepage_contains_leverancier_link(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Leveranciers');
    }

    /**
     * Test API endpoint returns JSON
     */
    public function test_api_leveranciers_returns_json(): void
    {
        $response = $this->get('/api/leveranciers');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true
        ]);
    }
}
