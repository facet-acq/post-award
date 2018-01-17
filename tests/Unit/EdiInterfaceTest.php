<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\EdiInterface;
use Illuminate\Database\QueryException;
use PDOException;

class EdiInterfaceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tracks_edi_interface_information()
    {
        factory(EdiInterface::class)->create();
        $this->assertCount(1, EdiInterface::all());
    }

    /** @test */
    public function it_can_handle_zero_size_files()
    {
        factory(EdiInterface::class)->create(['file_size' => 0]);
        $this->assertCount(1, EdiInterface::all());
    }

    /** @test */
    public function it_may_have_a_null_agreement()
    {
        factory(EdiInterface::class)->create(['agreement_uuid' => null]);
        $this->assertCount(1, EdiInterface::all());
    }

    /** @test */
    public function it_may_have_a_null_interface_version()
    {
        factory(EdiInterface::class)->create(['interface_version' => null]);
        $this->assertCount(1, EdiInterface::all());
    }

    /** @test */
    public function it_may_have_a_null_interface_source_and_destination()
    {
        factory(EdiInterface::class)->create([
            'interface_source' => null,
            'interface_destination' => null
        ]);
        $this->assertCount(1, EdiInterface::all());
    }

    /** @test */
    public function it_may_have_a_null_interface_control_number()
    {
        factory(EdiInterface::class)->create(['interface_control_number' => null]);
        $this->assertCount(1, EdiInterface::all());
    }

    /** @test */
    public function it_may_have_a_null_interface_at_timestamp()
    {
        factory(EdiInterface::class)->create(['interface_at' => null]);
        $this->assertCount(1, EdiInterface::all());
    }

    /** @test */
    public function it_may_not_have_a_null_queued_at_timestamp()
    {
        $this->expectException(QueryException::class);
        factory(EdiInterface::class)->create(['queued_at' => null]);
        $this->assertCount(0, EdiInterface::all());
    }

    /** @test */
    public function it_may_have_a_null_processed_at_timestamp()
    {
        factory(EdiInterface::class)->create(['processed_at' => null]);
        $this->assertCount(1, EdiInterface::all());
    }
}
