<?php

namespace Tests\Unit;

use App\Party;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PartiesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tracks_the_party()
    {
        $party = factory(Party::class)->create();
        $this->assertCount(1, Party::all());
    }

}
