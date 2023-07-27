<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Menu;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_api_returns_menu_list()
    {
        $menus = Menu::factory(5)->create();
        $expectedResponse = $menus->map(function ($menu) {
            return $menu->toArray();
        })->toArray();

        $response = $this->getJson('/api/v1/menu');

        $response->assertJson($expectedResponse);
    }

    public function test_api_product_store_successful()
    {
        $menu = [
            'menu_item' => 'chocolate',
            'price' => 12,
            'type' => 'drink',
            'image' => UploadedFile::fake()->image('chocolate.jpg'),
        ];

        $response = $this->postJson('/api/v1/menu', $menu);
        $response->assertStatus(201); // Change to 201 for successful creation
        $response->assertJsonFragment([
            'menu_item' => 'chocolate',
            'price' => number_format(12, 2),
            'type' => 'drink',
        ]);
    }
}
