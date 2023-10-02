<?php

namespace Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use JsonException;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_login_page_is_rendered(): void
    {
        $this->get(route('login'))
            ->assertStatus(200)
            ->assertSee('Login');
    }

    public function test_post_login_unregistered_user_can_not_login_with_error(): void
    {
        $this->post(route('login.post'), ['email' => 'a@a.com', 'password' => 'password'])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors();
    }

    /**
     * @throws JsonException
     */
    public function test_post_login_registered_user_can_login(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('test12345')
        ]);
        $this->post(route('login.post'), ['email' => $user->email, 'password' => 'test12345'])
            ->assertRedirect(route('home'))
            ->assertSessionHasNoErrors();
        $this->assertTrue(auth()->check());
        $this->assertTrue($user->is(auth()->user()));
    }

    public function test_post_user_can_register(): void
    {
        $name = fake()->name();
        $email = fake()->safeEmail();
        $password = 'test12345!';
        $this->post(route('register.post'), [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'confirm_password' => $password,
        ]);
        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
        ]);
    }
}
