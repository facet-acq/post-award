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

        $this->assertNotNull($agreement->order);
    }

    /** @test */
    public function it_tracks_the_release_identifier()
    {
        $agreement = factory(\App\Agreement::class)->create();

        $this->assertNotNull($agreement->release);
    }

    /** @test */
    public function it_adds_a_guid_to_each_agreement_as_the_id()
    {
        $agreement = factory(\App\Agreement::class)->create();
        $this->assertNotNull($agreement->uuid);
        $this->assertEquals(36, strlen($agreement->uuid));
    }

    /** @test */
    public function it_tracks_the_effective_date()
    {
        $agreement = factory(\App\Agreement::class)->create();
        $this->assertNotNull($agreement->effective_date);
        $this->assertInstanceOf(\Carbon\Carbon::class, $agreement->effective_date);
    }

    /** @test */
    public function it_tracks_total_agreement_value()
    {
        $agreement = factory(\App\Agreement::class)->create();
        $this->assertNotNull($agreement->total_value);
    }

    /** @test */
    public function it_allows_mass_assignment_of_an_agreement()
    {
        $orderId = 'ABC123-17-D-0001';
        $releaseId = 'XYZ789-17-F-0001';
        $effectiveDate = \Carbon\Carbon::now()->toDateString();
        $totalValue = 1000.05;

        $newAgreement = new \App\Agreement([
            'order' => $orderId,
            'release' => $releaseId,
            'effective_date' => $effectiveDate,
            'total_value' => $totalValue
        ]);

        $newAgreement->save();

        $this->assertDatabaseHas('agreements', [
            'order' => $orderId,
            'release' => $releaseId,
            'effective_date' => $effectiveDate,
            'total_value' => $totalValue
        ]);

        $this->assertEquals($orderId, $newAgreement->order);
        $this->assertEquals($releaseId, $newAgreement->release);
        $this->assertEquals($effectiveDate, $newAgreement->effective_date);
        $this->assertEquals($totalValue, $newAgreement->total_value);
    }
}
