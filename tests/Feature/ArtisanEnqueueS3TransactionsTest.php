<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Jobs\ProcessEdiFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Bus;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArtisanEnqueueInterfacesTest extends TestCase
{
    use RefreshDatabase;

    protected $fakeX12 = "ISA*00*          *00*          *ZZ*FAKE OUT       *ZZ*POST AWARD     *180120*1947*U*00305*000000001*0*T*~}GS*PO*FAKE OUT*POST AWARD*180120*1947*1*X*003051}ST*850*0001}BEG*22*KC*FAKEBUY18C0001**171221****FR*RD}FOB*PS*DE****DE}AMT*KC*123000}AT**17  18180400.5AAA*****Z00001  **01189998881999119725 3}REF*AX*AA}N1*BY*FAKE DOD BASE*10*Z00001}N1*SE*FAKE VENDOR*33*00001}N3*123 Main Street Suite 987}N4*Everytown*VA*99999*US}N1*PR*POST AWARD*10*Z00002}N1*ST*FAKE DOD BASE*10*Z00003}PO1*0001*10*EA*1230**PD*Nondescript Research Material*CL*Blue}CN1*FR}SCH*10*EA***106*180601*1700}AMT*123000}REF*AX*AA}CTT*1*10}AMT*TT*123000}SE*20*0001}GE*1*1}IEA*1*000000001}";

    /** @test */
    public function it_dispatches_the_job_to_process_an_edi_file()
    {
        // todo add a fake EDI file to the drive

        Bus::fake();

        Storage::makeDirectory('usdf/stdCWS/x12');
        Storage::put('usdf/stdCWS/x12/fake_file.x12', $this->fakeX12);

        $this->artisan('edi:enqueue');

        Bus::assertDispatched(ProcessEdiFile::class);
    }
}
