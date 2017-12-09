<?php

namespace Tests\Unit;

use App\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tracks_roles()
    {
        factory(Role::class)->create();
        $this->assertCount(1, Role::all());
    }

    /** @test */
    public function it_assigns_a_role_a_guid()
    {
        $role = factory(Role::class)->create();

        $this->assertNotNull($role->uuid);
        $this->assertEquals(36, strlen($role->uuid));
    }

    /** @test */
    public function it_seeds_a_seller_role()
    {
        $this->artisan('db:seed');
        $this->assertDatabaseHas('roles', ['description' => 'seller']);
    }

    /** @test */
    public function it_seeds_a_buyer_role()
    {
        $this->artisan('db:seed');
        $this->assertDatabaseHas('roles', ['description' => 'buyer']);
    }
}
