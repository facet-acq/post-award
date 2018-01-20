<?php

namespace App\Jobs;

use App\EdiInterface;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ClientException;

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
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EdiInterface $file)
    {
        $this->interfaceFile = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Parse EDI data into PHP object
        $ediTransaction = $this->parseEdiInterface();

        // Todo handle for multiple transactions per interface

        // Todo handle for formats other than and X12 PO/850, like PDS
        // Map the transaction to a Post Award Agreement
        $facetTransaction = $this->buildFacetAgreement($ediTransaction);

        // Post the result for real time processing
        $this->postAnAward($facetTransaction);

        // todo draw the association between the EdiInterface file and the transactions of any type which it generated

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
        $file = Storage::get($this->interfaceFile->path());
        $parsed = [$file];
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
        $client = new Client([
            'base_uri' => env('APP_URL') . '/api/v1/'
        ]);
        try {
            // Post transformed data to processing endpoint
            $result = $client->post('award', $facetTransaction);
            $response = json_decode($result->getBody());
            if ($result->getStatusCode() == 201) {
                Log::info('Successfully Processed EDI transaction for agreement'. $response['agreement']['uuid']);
                $this->logApiResult($result);
                return $response['agreement']['uuid'];
            }
            // Report any issues
            Log::warning('EDI Transaction processed but was not accepted for '.$this->interfaceFile->uuid);
            $this->logApiResult($result);
        } catch (RequestException $e) {
            Log::critical('Cannot communicate with post-award server');
            $this->logApiResult($e, 'Post Award Request failed');
        } catch (ClientException $c) {
            Log::critical('Guzzle Client Error');
            $this->logApiResult($c, 'Post Award Request failed');
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
        if (env('APP_ENV') != 'local') {
            Storage::move($ediFileWithPrefix, 'archive/' . $this->interfaceFile->uuid);
        }

        // AWS will hold it for n days, then archive to Glacier for 5 years based on the bucket's life-cycle rules
        // todo build this bucket creation and lifecycle rules in terraform
        // Transactions are intentionally stored without meaningful extensions or identifying information
    }

    protected function logApiResult($result, $message = "Api Request")
    {
        Log::debug($message, [
            'request' => Psr7\str($result->getRequest()),
            'response' => $result->hasResponse() ? Psr7\str($result->getResponse()): null,
            // 'headers' => $result->getHeaders(),
            // 'status_code' => $result->getStatusCode(),
            // 'message' => $result->getReasonPhrase()
        ]);
    }
}
