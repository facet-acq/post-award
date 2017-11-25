<?php

namespace Tests\Unit;

use App\Party;
use App\Agreement;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PartiesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tracks_the_party()
    {
        factory(Party::class)->create();
        $this->assertCount(1, Party::all());
    }

    public function it_has_many_agreements()
    {
        $party = factory(Party::class)->create();

        $agreements = factory(Agreement::class, 3)->create();
        $agreements->each(function ($agreement) use ($party) {
            $agreement->addBuyer($party);
        });

        $this->assertCount(3, $party->agreements->get());
    }
}
