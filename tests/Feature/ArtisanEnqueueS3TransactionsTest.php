<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Jobs\ProcessEdiFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArtisanEnqueueInterfacesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_dispatches_the_job_to_process_an_edi_file()
    {
        // todo add a fake EDI file to the drive

        Bus::fake();

        $this->artisan('edi:enqueue');

        Bus::assertDispatched(ProcessEdiFile::class);
    }
}
