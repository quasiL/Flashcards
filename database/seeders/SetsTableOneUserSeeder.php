<?php

namespace Database\Seeders;

use App\Models\Set;
use App\Models\User;
use Illuminate\Database\Seeder;

class SetsTableOneUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $user = User::factory()->create()->id;
        Set::factory()->count(3)->create([
            'user_id' => $user
        ]);
    }
}
