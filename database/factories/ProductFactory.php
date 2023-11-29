<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $nameProduct = ['Jaqueta Daily', 'Vestido Pamela Branco', 'Vestido Olívia Onça', 'Vestido Fúcsia'];

        return [
            'id' => Str::orderedUuid(),
            'name' => $this->faker->randomElement($nameProduct),
            'amount' => $this->faker->numberBetween(1,300),
            'value' => $this->faker->randomFloat(2, 39.90, 159.90),
        ];
    }
}
