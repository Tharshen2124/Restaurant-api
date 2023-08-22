<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use App\Models\Menu;
use Illuminate\Http\UploadedFile;
use App\Http\Resources\V1\MenuResource;
use App\Http\Resources\V1\MenuCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_api_returns_menu_list()
    {
        Menu::factory(3)->create();
        
        $response = $this->getJson('/api/v1/menu');
        
        $menu1 = [
            "data" => [
                [
                    "image",
                    "menu_item",
                    "price",
                    "type",
                ]
            ]
        ];

        $menu2 = [
            "message" => 'success',
        ];

        // use it for dynamic data and if you have a structure
        $response->assertJsonStructure($menu1);
        
        // use it for hard-coded data
        $response->assertJsonFragment($menu2);
    }

    















    /* public function test_api_product_store_successful()
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
    } */
}
