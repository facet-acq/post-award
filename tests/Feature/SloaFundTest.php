<?php

namespace Tests\Feature;

use App\SloaFund;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SloaFundTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tracks_the_sub_class()
    {
        $sloaFund = factory(SloaFund::class)->create(['sub_class' => '46']);

        $this->assertNotNull($sloaFund->sub_class);
        $this->assertDatabaseHas('sloa_funds', ['sub_class' => $sloaFund->sub_class]);
    }

    /** @test */
    public function it_adds_a_guid_to_each_fund_as_the_id()
    {
        $fund = factory(SloaFund::class)->create();
        $this->assertNotNull($fund->uuid);
        $this->assertEquals(36, strlen($fund->uuid));
    }
}
