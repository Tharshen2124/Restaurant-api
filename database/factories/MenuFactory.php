<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'menu_item' => $this->faker->name,
            'type' => $this->faker->randomElement(['drink', 'food']),
            'price' => $this->faker-> randomFloat(1, 10, 20),
            'image' => $this->faker->image(null, 360, 360, 'animals', true, true, 'cats', true),
        ];
    }
}
