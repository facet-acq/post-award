<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgreementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tracks_the_order_identifier()
    {
        $agreement = factory(\App\Agreement::class)->create();

        $this->assertNotNull($agreement->order_identifier);
    }
}
