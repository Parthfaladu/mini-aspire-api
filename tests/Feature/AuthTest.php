<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    /**
     * customer registration
     *
     * @return void
     */
    public function test_customer_registration()
    {
        $customer = User::factory()->make();
        $this->postJson('/api/customer/register', $customer->makeVisible('password')->toArray())
                         ->assertStatus(201)
                         ->assertJsonStructure([
                            'accessToken',
                            'plainTextToken'
                        ]);
        $this->assertTrue(true);
    }

    /**
     * customer registration with invalid request
     *
     * @return void
     */
    public function test_customer_register_invalid()
    {
        $this->postJson('/api/customer/register', [])
                         ->assertStatus(422)
                         ->assertJson(['message' => 'The given data was invalid.']);

       $this->assertTrue(true);
    }

    /**
     * admin registration
     *
     * @return void
     */
    public function test_admin_registration()
    {
        $admin = User::factory()->admin()->make();
        $this->postJson('/api/admin/register', $admin->makeVisible('password')->toArray())
                         ->assertStatus(201);

        $this->assertTrue(true);
    }

    /**
     * admin registration with invalid request
     *
     * @return void
     */
    public function test_admin_register_invalid()
    {
        $this->postJson('/api/admin/register', [])
                         ->assertStatus(422)
                         ->assertJson(['message' => 'The given data was invalid.']);

       $this->assertTrue(true);
    }

    /**
     * customer or admin login
     *
     * @return void
     */
    public function test_login()
    {
        $user = User::first();
        $this->postJson('/api/login', ["email" => $user->email, "password" => "secret"])
                         ->assertStatus(200)
                         ->assertJsonStructure([
                            'accessToken',
                            'plainTextToken'
                        ]);

        $this->assertTrue(true);
    }

    /**
     * login with invalid email address request
     *
     * @return void
     */
    public function test_login_invalid_email()
    {
        $this->postJson('/api/login', ["email" => "abc", "password" => "secret"])
                         ->assertStatus(422)
                         ->assertJson(['message' => 'The given data was invalid.']);

       $this->assertTrue(true);
    }

    /**
     * login with without password field request
     *
     * @return void
     */
    public function test_login_invalid_password()
    {
        $user = User::first();
        $this->postJson('/api/login', ["email" => $user->email])
                         ->assertStatus(422)
                         ->assertJson(['message' => 'The given data was invalid.']);

       $this->assertTrue(true);
    }
}
