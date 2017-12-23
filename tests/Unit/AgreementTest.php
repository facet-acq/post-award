<?php

namespace Tests\Unit;

use App\Party;
use App\Agreement;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgreementTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /** @test */
    public function it_tracks_the_order_identifier()
    {
        $agreement = factory(Agreement::class)->create();
        $this->assertNotNull($agreement->order);
    }

    /** @test */
    public function it_tracks_the_release_identifier()
    {
        $agreement = factory(Agreement::class)->create();
        $this->assertNotNull($agreement->release);
    }

    /** @test */
    public function it_allows_release_identifier_to_be_null()
    {
        $agreement = factory(Agreement::class)->create(['release' => null]);
        $this->assertNull($agreement->release);
    }

    /** @test */
    public function it_adds_a_guid_to_each_agreement_as_the_id()
    {
        $agreement = factory(Agreement::class)->create();
        $this->assertNotNull($agreement->uuid);
        $this->assertEquals(36, strlen($agreement->uuid));
    }

    /** @test */
    public function it_tracks_the_effective_date()
    {
        $agreement = factory(Agreement::class)->create();
        $this->assertNotNull($agreement->effective_date);
        $this->assertInstanceOf(\Carbon\Carbon::class, $agreement->effective_date);
    }

    /** @test */
    public function it_tracks_total_agreement_value()
    {
        $agreement = factory(Agreement::class)->create();
        $this->assertNotNull($agreement->total_value);
    }

    /** @test */
    public function it_allows_mass_assignment_of_an_agreement()
    {
        $orderId = 'ABC123-17-D-0001';
        $releaseId = 'XYZ789-17-F-0001';
        $effectiveDate = \Carbon\Carbon::now()->toDateString();
        $totalValue = 1000.05;

        $newAgreement = new Agreement([
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

    /** @test */
    public function it_integrates_with_eloquent_find()
    {
        $agreement = factory(Agreement::class)->create();
        $agreementFound = Agreement::find($agreement->uuid);

        $this->assertEquals($agreement->uuid, $agreementFound->uuid);

        $agreementSearched = Agreement::where('uuid', $agreement->uuid)->get();
        $this->assertCount(1, $agreementSearched);
    }

    /** @test */
    public function it_can_add_a_buyer()
    {
        $party = factory(Party::class)->create();
        $agreement = factory(Agreement::class)->create();

        $agreement->addBuyer($party);

        $this->assertNotNull($agreement->buyer->first());
        $this->assertEquals($party->uuid, $agreement->buyer->first()->uuid);
    }

    /** @test */
    public function it_can_add_a_seller()
    {
        $party = factory(Party::class)->create();
        $agreement = factory(Agreement::class)->create();

        $agreement->addSeller($party);

        $this->assertNotNull($agreement->seller->first());
        $this->assertEquals($party->uuid, $agreement->seller->first()->uuid);
    }

    /** @test */
    public function it_identifies_the_right_buyer()
    {
        $buyerParty = factory(Party::class)->create();
        $sellerParty = factory(Party::class)->create();

        $agreement = factory(Agreement::class)->create()
            ->addSeller($sellerParty)
            ->addBuyer($buyerParty);

            $this->assertEquals($buyerParty->uuid, $agreement->buyer->first()->uuid);
    }
}
