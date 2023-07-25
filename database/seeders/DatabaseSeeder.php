<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Menu;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Menu::factory(10)->create();
        Category::factory(10)->create();

        foreach(Category::all() as $category) {
            $menu = Menu::inRandomOrder()->take(rand(1,3))->pluck('id');
            $category->menus()->attach($menu);
        }
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
