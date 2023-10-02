<?php

namespace Feature;

use App\Models\User;
use Tests\TestCase;

class SetsControllerTest extends TestCase
{
    public function test_post_user_can_create_set(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post(route('sets.store'), [
            'set-name' => 'my set',
        ]);
        $this->assertDatabaseHas('sets', [
            'name' => 'my set',
            'user_id' => $user->id
        ]);
    }
}
