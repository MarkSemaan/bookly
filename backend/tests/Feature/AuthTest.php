<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private string $email = 'ali@example.com';
    private string $password = 'secret123';

    public function test_user_can_register()
    {
        $res = $this->postJson('/api/v0.1/guest/register', [
            'firstname' => 'Ali',
            'lastname' => 'Serhan',
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password,
        ]);

        $res->assertCreated()
            ->assertJsonStructure([
                'status',
                'payload' => [
                    'user' => [
                        'id',
                        'firstname',
                        'lastname',
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                    'access_token'
                ]
            ]);

        $this->assertDatabaseHas('users', ['email' => $this->email]);
    }

    public function test_user_can_login()
    {
        User::factory()->create([
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $res = $this->postJson('/api/v0.1/guest/login', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $res->assertOk()
            ->assertJsonStructure([
                'status',
                'payload' => [
                    'access_token'
                ]
            ]);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $res = $this->postJson('/api/v0.1/guest/login', [
            'email' => 'wrong@example.com',
            'password' => 'invalid123',
        ]);

        $res->assertUnauthorized()
            ->assertJson([
                'status' => false,
                'payload' => 'Unauthorized'
            ]);
    }
}
