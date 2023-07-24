<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Menu;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_api_returns_menu_list()
    {
        $menu = Menu::factory()->create();
        $response = $this->getJson('/api/v1/menu');

        $response->assertJson([$menu->toArray()]);
    }
}
