<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_code' => 'IC-100' . rand(11, 5000),
            'description' => 'Name of Product' . rand(10,5000),
            'unit_price' => mt_rand(100, 1000),
        ];
    }
}
