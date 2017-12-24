<?php

namespace Tests\Unit;

use App\Agreement;
use App\Fund;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FundTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tracks_funds_with_a_guid()
    {
        $fund = factory(Fund::class)->create();

        $this->assertNotNull($fund->uuid);
        $this->assertEquals(36, strlen($fund->uuid));
    }

    /** @test */
    public function it_pulls_the_trial_balance_for_a_fund()
    {
        $fund = factory(Fund::class)->create();

        $agreement = factory(Agreement::class)->create();
        $amount = 250;
        $fund->obligate($amount, $agreement->uuid);

        $agreementTwo = factory(Agreement::class)->create();
        $amountTwo = 1500.23;
        $fund->obligate($amountTwo, $agreementTwo->uuid);

        $trialBalance = $fund->balance();
        // dd($trialBalance);
        $this->assertEquals($amount + $amountTwo, $trialBalance['obligation']);
    }
}
