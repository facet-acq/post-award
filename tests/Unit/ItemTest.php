<?php

namespace Tests\Unit;

use App\Fund;
use App\Item;
use Tests\TestCase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_adds_a_guid_to_each_item_as_the_id()
    {
        $item = factory(Item::class)->create();
        $this->assertNotNull($item->uuid);
        $this->assertEquals(36, strlen($item->uuid));
    }

    /** @test */
    public function it_tracks_item_identifiers_and_does_not_allow_them_to_be_null()
    {
        $item = factory(Item::class)->create();
        $this->assertNotNull($item->item_identifier);
        $this->assertDatabaseHas('items', ['item_identifier' => $item->item_identifier]);
    }

    /** @test */
    public function it_tracks_item_quantities_and_does_not_allow_them_to_be_null()
    {
        $item = factory(Item::class)->create();
        $this->assertNotNull($item->quantity);
        $this->assertDatabaseHas('items', ['quantity' => $item->quantity]);
    }

    /** @test */
    public function it_tracks_item_unit_costs_and_does_not_allow_them_to_be_null()
    {
        $item = factory(Item::class)->create();
        $this->assertNotNull($item->unit_cost);
        $this->assertDatabaseHas('items', ['unit_cost' => $item->unit_cost]);
    }

    /** @test */
    public function it_belongs_to_an_agreement()
    {
        $item = factory(Item::class)->create();
        $this->assertNotNull($item->agreement()->first());
    }

    /** @test */
    public function it_cannot_exist_outside_of_an_agreement()
    {
        $this->expectException(QueryException::class);
        $item = factory(Item::class)->create(['agreement_uuid' => null]);
    }

    /** @test */
    public function it_tracks_which_fund_funded_the_item()
    {
        $amount = 100;
        $item = factory(Item::class)->create([
            'quantity' => 1,
            'unit_cost' => $amount
        ]);
        $fund = factory(Fund::class)->create();
        $fund->obligate($amount, $item->agreement()->first()->uuid);

        $item->funds()->attach($fund, ['amount' => $amount]);

        $this->assertEquals($item->funds()->first()->uuid, $fund->uuid);
        $this->assertEquals($item->totalFunded(), $amount);
    }

    /** @test */
    public function it_can_have_multiple_funds()
    {
        $amountOne = 50;
        $amountTwo = 75;

        $item = factory(Item::class)->create([
            'quantity' => 1,
            'unit_cost' => $amountOne + $amountTwo
        ]);

        $fundOne = factory(Fund::class)->create();
        $fundOne->obligate($amountOne, $item->agreement()->first()->uuid);

        $fundTwo = factory(Fund::class)->create();
        $fundTwo->obligate($amountTwo, $item->agreement()->first()->uuid);

        $item->funds()->attach($fundOne, ['amount' => $amountOne]);
        $item->funds()->attach($fundTwo, ['amount' => $amountTwo]);

        $this->assertCount(2, $item->funds);
        $this->assertEquals($item->totalFunded(), $amountOne + $amountTwo);
    }

    /** @test */
    public function it_knows_its_total_cost()
    {
        $unitCost = 100;
        $quantity = 20;
        $item = factory(Item::class)->create([
            'quantity' => $quantity,
            'unit_cost' => $unitCost
        ]);

        $this->assertEquals($unitCost * $quantity, $item->totalCost());
    }
}
