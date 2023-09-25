<?php

namespace Database\Seeders;

use App\Models\Flashcard;
use App\Models\Set;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlashcardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $user = User::factory()->create()->id;
        $set = Set::factory()->create([
            'user_id' => $user
        ])->id;
        Flashcard::factory()->count(3)->create([
            'set_id' => $set
        ]);
    }
}
