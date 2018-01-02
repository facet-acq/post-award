<?php

namespace Tests\Unit;

use App\Item;
use Tests\TestCase;
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
}
