<?php

namespace App\Console\Commands;

use \Illuminate\Support\Facades\Log;
use \Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

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
            // Generate a Uuid to tie this into
            $uuid = (string) \Uuid::generate(4);

            // Get the transaction data
            $transaction = Storage::disk('s3')->get($ediFile);

            // Map the transaction to a Post Award Agreement
            $this->facetTransaction = $this->buildFacetAgreement($transaction);

            // Post the result for real time processing
            $agreementUuid = $this->postAnAward();

            // extract original file data and save to trading partners table
            // Insert the:
            // file metadata
            // $agreementUuid
            // trading partner info
            // channel info
            // archive file UUID
            // file type
            // EDI version

            // Move the transaction to the archived bucket
            // Storage::disk('s3')->move($ediFile, 'archive/s3/path/'.$uuid);
            // AWS will hold it for n days, then archive to Glacier for 5 years based on the bucket's life-cycle rules
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
        $parsed = $interfaceFile; // ToDo call the parser or build it here
        return $parsed;
    }

    protected function buildFacetAgreement($awardTransaction)
    {
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
                $this->info('Successfully Processed agreement for EDI transaction '.$agreementUuid);
                return $response['agreement']['uuid'];
            } else {
                $this->warn('EDI Transaction processed but was not accepted.');
                Log::warning('Request: '.$result->getRequest());
                Log::warning('Response: '.$result->getBody());
            }
        } catch (RequestException $exception) {
            dd($exception);
            Log::critical('Cannot communicate with post-award server');
            Log::critical('Request: '.$exception->getRequest());
            if ($exception->hasResponse()) {
                Log::critical('Response: '.$exception->getBody());
            }
        }

        return null;
    }
}
