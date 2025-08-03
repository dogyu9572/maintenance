<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_login_form()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'login_id' => 'testuser',
            'password' => Hash::make('password123'),
            'role' => 'user'
        ]);

        $response = $this->post('/login', [
            'login_id' => 'testuser',
            'password' => 'password123'
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_login_with_invalid_credentials()
    {
        $response = $this->post('/login', [
            'login_id' => 'wronguser',
            'password' => 'wrongpassword'
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('login_id');
        $this->assertGuest();
    }

    public function test_admin_login_redirects_to_admin_dashboard()
    {
        $admin = User::factory()->create([
            'login_id' => 'admin',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        $response = $this->post('/login', [
            'login_id' => 'admin',
            'password' => 'password123'
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticated();
    }

    public function test_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
