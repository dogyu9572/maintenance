<?php

namespace Tests;

use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

trait TestHelper
{
    use RefreshDatabase;

    /**
     * Create a test user with default values
     */
    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }

    /**
     * Create a test admin user
     */
    protected function createAdmin(array $attributes = []): User
    {
        return User::factory()->admin()->create($attributes);
    }

    /**
     * Create a test client
     */
    protected function createClient(array $attributes = []): Client
    {
        return Client::factory()->create($attributes);
    }

    /**
     * Login as a user
     */
    protected function loginAsUser(User $user = null): User
    {
        $user = $user ?? $this->createUser();
        $this->actingAs($user);
        return $user;
    }

    /**
     * Login as an admin
     */
    protected function loginAsAdmin(User $admin = null): User
    {
        $admin = $admin ?? $this->createAdmin();
        $this->actingAs($admin);
        return $admin;
    }
}
