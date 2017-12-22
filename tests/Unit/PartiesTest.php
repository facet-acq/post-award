<?php

namespace Tests\Unit;

use App\Party;
use App\Agreement;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PartiesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /** @test */
    public function it_tracks_the_party()
    {
        factory(Party::class)->create();
        $this->assertCount(1, Party::all());
    }

    /** @test */
    public function it_has_many_agreements()
    {
        $party = factory(Party::class)->create();

        $agreements = factory(Agreement::class, 3)->create();
        $agreements->each(function ($agreement) use ($party) {
            $agreement->addBuyer($party);
        });

        $this->assertCount(3, $party->agreements()->get());
    }

    /** @test */
    public function it_identifies_different_roles()
    {
        $sellerParty = factory(Party::class)->create();
        $buyerParty = factory(Party::class)->create();
        $agreement = factory(Agreement::class)->create();

        $agreement->addSeller($sellerParty);
        $agreement->addBuyer($buyerParty);

        $this->assertCount(1, $sellerParty->agreements);
        $this->assertEquals($agreement->uuid, $sellerParty->agreements()->first()->uuid);
    }
}
