<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_admin()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create(['is_admin' => false]);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($user->isAdmin());
    }

    public function test_user_has_client_relationship()
    {
        $client = Client::factory()->create();
        $user = User::factory()->create(['client_id' => $client->idx]);

        $this->assertInstanceOf(Client::class, $user->client);
        $this->assertEquals($client->idx, $user->client->idx);
    }

    public function test_user_can_have_maintenance_requests()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $user->maintenanceRequests);
    }

    public function test_user_can_be_manager()
    {
        $manager = User::factory()->create();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $manager->managedRequests);
    }

    public function test_user_can_be_worker()
    {
        $worker = User::factory()->create();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $worker->workedRequests);
    }
}
