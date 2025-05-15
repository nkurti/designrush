<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProviderApiTest extends TestCase
{
    public function test_index_returns_providers()
    {
        Category::factory()->hasProviders(3)->create();

        $response = $this->getJson('/api/providers');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }


}
