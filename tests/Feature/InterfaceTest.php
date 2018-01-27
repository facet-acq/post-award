<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\EdiInterface;
use App\Jobs\ProcessEdiFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InterfaceTest extends TestCase
{
    use RefreshDatabase;

    protected $fakeX12 = 'ISA*00*          *00*          *ZZ*FAKE OUT       *ZZ*POST AWARD     *180120*1947*U*00305*000000001*0*T*~}GS*PO*FAKE OUT*POST AWARD*180120*1947*1*X*003051}ST*850*0001}BEG*22*KC*FAKEBUY18C0001**171221****FR*RD}FOB*PS*DE****DE}AMT*KC*123000}AT**17  18180400.5AAA*****Z00001  **01189998881999119725 3}REF*AX*AA}N1*BY*FAKE DOD BASE*10*Z00001}N1*SE*FAKE VENDOR*33*00001}N3*123 Main Street Suite 987}N4*Everytown*VA*99999*US}N1*PR*POST AWARD*10*Z00002}N1*ST*FAKE DOD BASE*10*Z00003}PO1*0001*10*EA*1230**PD*Nondescript Research Material*CL*Blue}CN1*FR}SCH*10*EA***106*180601*1700}AMT*123000}REF*AX*AA}CTT*1*10}AMT*TT*123000}SE*20*0001}GE*1*1}IEA*1*000000001}';

    /** @test */
    public function it_accepts_a_new_interface_notification()
    {
        $directory = 'usgov/contract/x12';
        $fileName = 'agreement.x12';
        $path = $directory . '/' . $fileName;

        if (!Storage::exists($directory)) {
            Storage::makeDirectory('usgov/contract/x12');
        }
        if (!Storage::exists($path)) {
            Storage::put($path, $this->fakeX12);
        }

        Bus::fake();

        $response = $this->post('api/v1/interface/file', ['file' => [$path]])
            ->assertStatus(201)
            ->assertJsonStructure([
                'result' => [
                    'file_size',
                    'file_name',
                    'file_at',
                    'interface_partner',
                    'interface_channel',
                    'queued_at',
                    'processed_at',
                    'uuid',
                    'updated_at',
                    'created_at'
                ]
            ]);

        Bus::assertDispatched(ProcessEdiFile::class);
    }

    /** @test */
    public function it_fetches_the_record_by_uuid_and_returns_as_json()
    {
        $interface = factory(EdiInterface::class)->create(['interface_at' => Carbon::now()]);

        $this->getJson('api/v1/interface/file/' . $interface->uuid)
            ->assertStatus(200)
            ->assertJson([
                'result' => [
                    'uuid' => $interface->uuid,
                    'file_size' => $interface->file_size,
                    'file_name' => $interface->file_name,
                    'file_type' => $interface->file_type,
                    'file_at' => $interface->file_at->toDateTimeString(),
                    'interface_partner' => $interface->interface_partner,
                    'interface_channel' => $interface->interface_channel,
                    'interface_version' => $interface->interface_version,
                    'interface_source' => $interface->interface_source,
                    'interface_destination' => $interface->interface_destination,
                    'interface_control_number' => $interface->interface_control_number,
                    'interface_at' => $interface->interface_at->toDateTimeString(),
                    'queued_at' => $interface->queued_at->toDateTimeString(),
                    'processed_at' => $interface->processed_at,
                    'created_at' => $interface->created_at->toDateTimeString(),
                    'updated_at' => $interface->updated_at->toDateTimeString()
                ]
            ]);
    }
}
