<?php

namespace Database\Factories;

use App\Models\Flashcard;
use App\Models\Set;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Flashcard>
 */
class FlashcardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => fake()->word(),
            'answer' => fake()->word(),
            'set_id' => function () {
                return self::factoryForModel(Set::class)->create()->id;
            }
        ];
    }
}
