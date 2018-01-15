<?php

namespace App\Console\Commands;

use \Illuminate\Support\Facades\Log;
use \Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Carbon\Carbon;

class ProcessIncomingEdi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'edi:incoming';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes all incoming EDI files in the bucket';

    /**
     * The HTTP client for reporting
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    protected $facetTransaction;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = new Client([
            'base_uri' => env('APP_URL').'/api/v1/'
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // List all files on the drive
        $workList = Storage::disk('s3')->allFiles();

        // Loop each file and parse it into a usable object
        foreach ($workList as $ediFile) {
            // Get the transaction data
            $transaction = Storage::disk('s3')->get($ediFile);

            // Parse EDI data into PHP object
            $ediTransaction = $this->parseEdiInterface($transaction);

            // Map the transaction to a Post Award Agreement
            $this->facetTransaction = $this->buildFacetAgreement($transaction);

            // Post the result for real time processing
            $agreementUuid = $this->postAnAward();

            // extract original file data and save to trading partners table
            $path = explode('/', $ediFile);
            $archive = EdiInterface::create([
                'agreement' => $agreementUuid,
                'file_size' => Storage::disk('s3')->size($ediFile),
                'file_name' => $path[sizeof($path)-1],
                'file_type'=>  'x12', // todo identify a more reliable way to derive this than extension
                'file_at' => Carbon::createFromTimestamp(Storage::disk('s3')->lastModified($ediFile), 'America/New_York'),
                'interface_partner' => 'test', // todo pull from s3 prefix
                'interface_channel' => 'manual', // todo pull from s3 prefix
                'interface_version' => '003050', // todo pull from GS08
                'interface_source' => 'us defense forces', // todo pull from ISA06
                'interface_destination' => 'facet', // todo pull from ISA08
                'interface_control_number' => null, // todo pull from ISA13
                'interface_at'=> null // todo pull from ISA Carbon::createFromFormat('ymdHi', ISA09.ISA10, 'UTC');
            ]);

            // Move the transaction to the archived bucket
            if (env(APP_ENV) != 'local') {
                Storage::disk('s3')->move($ediFile, 'archive/'.$archive->uuid);
            }
            // AWS will hold it for n days, then archive to Glacier for 5 years based on the bucket's life-cycle rules
            // todo build this bucket creation and lifecycle rules in terraform
            // Transactions are intentionally stored without meaningful extensions or identifying information
        }
    }

    /**
     * For each incoming file
     *
     * @return array
     */
    protected function parseEdiInterface($interfaceFile)
    {
        $parsed = $interfaceFile;
        // ToDo call the parser or build it here
        // Return the resulting object
        return $parsed;
    }

    protected function buildFacetAgreement()
    {
        // Map the post body here
        // return [
        //     'agreement_details' => [
        //         'order_identifier' => 'acb123',
        //         'release_identifier' => null,
        //         'total_amount' => 200
        //     ],
        //     'fund_list' => [
        //         [],
        //         []
        //     ],
        //     'item_list' => [
        //         [],
        //         []
        //     ]
        // ];
        return null;
    }

    protected function postAnAward()
    {
        try {
            // Post transformed data to processing endpoint
            $result = $this->client->post('award', $this->facetTransaction);
            $response = json_decode($result->getBody());
            if ($result->getStatusCode() == 201) {
                $this->info('Successfully Processed EDI transaction for agreement '.$response['agreement']['uuid']);
                return $response['agreement']['uuid'];
            }
            // Report any issues
            $this->warn('EDI Transaction processed but was not accepted.');
            Log::warning('Request', ['request' => $result->getRequest()]);
            Log::warning('Response', ['response' => $result->getBody()]);
        } catch (RequestException $exception) {
            Log::critical('Cannot communicate with post-award server');
            Log::critical('Request', ['request' => $exception->getRequest()]);
            if ($exception->hasResponse()) {
                Log::critical('Response', ['response' => $exception->getBody()]);
            }
        }
        return null;
    }
}
