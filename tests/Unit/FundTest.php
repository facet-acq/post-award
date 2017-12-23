<?php

namespace Tests\Unit;

use App\Fund;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FundTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tracks_funds()
    {
        $fund = factory(Fund::class)->create();

        $this->assertNotNull($fund->amount);
        $this->assertDatabaseHas('funds', ['amount' => $fund->amount]);
    }

    /** @test */
    public function it_adds_a_guid_to_each_fund_as_the_id()
    {
        $fund = factory(Fund::class)->create();
        $this->assertNotNull($fund->uuid);
        $this->assertEquals(36, strlen($fund->uuid));
    }
}
