<?php

namespace Database\Factories;

use App\Models\Set;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Set>
 */
class SetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'number' => fake()->unique()->numberBetween(100000, 999999),
            'user_id' => function () {
                return self::factoryForModel(User::class)->create()->id;
            }
        ];
    }
}
