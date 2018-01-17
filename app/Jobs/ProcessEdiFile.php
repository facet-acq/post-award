<?php

namespace App\Jobs;

use App\EdiInterface;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessEdiFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * EdiInterface eloquent model
     *
     * @var \App\EdiInterface
     */
    protected $interfaceFile;

    /**
     * The HTTP client for reporting
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EdiInterface $file)
    {
        $this->interfaceFile = $file;
        $this->client = new Client([
            'base_uri' => env('APP_URL') . '/api/v1/'
        ]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Parse EDI data into PHP object
        $ediTransaction = $this->parseEdiInterface($transaction);

        // Todo handle for multiple transactions per interface

        // Todo handle for formats other than and X12 PO/850, like PDS
        // Map the transaction to a Post Award Agreement
        $facetTransaction = $this->buildFacetAgreement($ediTransaction);

        // Post the result for real time processing
        $agreementUuid = $this->postAnAward($facetTransaction);

        // Move the transaction to the archived bucket
        $this->archiveProcessedFile($this->interfaceFile->path());
    }

    /**
     * For each incoming file
     *
     * @return array
     */
    protected function parseEdiInterface()
    {
        $file = Storage::disk('s3')->get($this->interfaceFile->path());
        $parsed = $file;
        // ToDo call the parser or build it here
        // Return the resulting object
        return $parsed;
    }

    protected function buildFacetAgreement($ediTransaction)
    {
        // Map the post body here into multi-dimensional array
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
        return $ediTransaction;
    }

    protected function postAnAward($facetTransaction)
    {
        try {
            // Post transformed data to processing endpoint
            $result = $this->client->post('award', $facetTransaction);
            $response = json_decode($result->getBody());
            if ($result->getStatusCode() == 201) {
                $this->info('Successfully Processed EDI transaction for agreement ' . $response['agreement']['uuid']);
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
                Log::critical('Response', ['response' => $exception->getMessage()]);
            }
        }

        return null;
    }

    /**
     * Moves the processed EDI file to archive
     *
     * @param string $ediFileWithPrefix
     */
    protected function archiveProcessedFile($ediFileWithPrefix)
    {
        if (env(APP_ENV) != 'local') {
            Storage::disk('s3')->move($ediFileWithPrefix, 'archive/' . $this->interfaceFile->uuid);
        }

        // AWS will hold it for n days, then archive to Glacier for 5 years based on the bucket's life-cycle rules
        // todo build this bucket creation and lifecycle rules in terraform
        // Transactions are intentionally stored without meaningful extensions or identifying information
    }
}
