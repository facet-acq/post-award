<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\SloaAccountingLine;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SloaAccountingLineTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_adds_a_guid_to_each_fund_as_the_id()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->uuid);
        $this->assertEquals(36, strlen($sloaAccountingLine->uuid));
    }

    /** @test */
    public function it_can_identify_its_supporting_fund()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $sloaAccountingLine->funds()->create(['amount' => 100]);
        $this->assertNotNull($sloaAccountingLine->funds);
        $this->assertCount(1, $sloaAccountingLine->funds);
    }

    /** @test */
    public function it_tracks_the_sub_class()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['sub_class' => '46']);

        $this->assertNotNull($sloaAccountingLine->sub_class);
        $this->assertDatabaseHas('sloa_accounting_lines', ['sub_class' => $sloaAccountingLine->sub_class]);
    }

    /** @test */
    public function it_allows_the_sub_class_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['sub_class' => null]);

        $this->assertNull($sloaAccountingLine->sub_class);
        $this->assertDatabaseHas('sloa_accounting_lines', ['sub_class' => null]);
    }

    /** @test */
    public function it_tracks_the_department_transfer()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['department_transfer' => '11']);

        $this->assertNotNull($sloaAccountingLine->department_transfer);
        $this->assertDatabaseHas('sloa_accounting_lines', ['department_transfer' => $sloaAccountingLine->department_transfer]);
    }

    /** @test */
    public function it_allows_the_department_transfer_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['department_transfer' => null]);

        $this->assertNull($sloaAccountingLine->department_transfer);
        $this->assertDatabaseHas('sloa_accounting_lines', ['department_transfer' => null]);
    }

    /** @test */
    public function it_tracks_the_department_regular()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->department_regular);
        $this->assertDatabaseHas('sloa_accounting_lines', ['department_regular' => $sloaAccountingLine->department_regular]);
    }
}
