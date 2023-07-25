<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory(10)->create();

        foreach(Category::all() as $category) {
            $menu = Menu::inRandomOrder()->take(rand(1,3))->pluck('id');
            $category->menus()->attach($menu);
        }
    }
}
