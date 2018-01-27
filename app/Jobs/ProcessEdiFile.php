<?php

namespace App\Jobs;

use GuzzleHttp\Psr7;
use App\EdiInterface;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        Log::info('Invoked for '.$this->interfaceFile->file_name);

        // Parse EDI data into PHP object
        $ediTransaction = $this->parseEdiInterface();

        // Todo handle for multiple transactions per interface

        // Todo handle for formats other than and X12 PO/850, like PDS
        // Map the transaction to a Post Award Agreement
        $facetTransaction = $this->buildFacetAgreement($ediTransaction);

        // Post the result for real time processing
        // $this->postAnAward($facetTransaction);

        // todo draw the association between the EdiInterface file and the transactions of any type which it generated

        // Move the transaction to the archived bucket
        $this->archiveProcessedFile($this->interfaceFile->path());
    }

    /**
     * For each incoming file parse it and return all transactions for processing
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

    /**
     * Process the Pedi object into an Agreement object
     *
     * @return array
     */
    protected function buildFacetAgreement($ediTransaction)
    {
        // Map the post body here into multi-dimensional array
        return $ediTransaction;
    }

    /**
     * Submits the Post-Award compliant agreement data to the post-award REST endpoint for processing
     *
     * @return string
     */
    protected function postAnAward($facetTransaction)
    {
        $client = new Client([
            'base_uri' => config('post-award.edi.file_processing.url')
        ]);
        try {
            // Post transformed data to processing endpoint
            $result = $client->post('award', $facetTransaction);
            $response = json_decode($result->getBody());
            if ($result->getStatusCode() == 201) {
                // todo log the actual request and response at the debug level
                return $response['agreement']['uuid'];
            }
            // Report any issues
            Log::warning('EDI Transaction processed but was not accepted for '.$this->interfaceFile->uuid);
            $this->logApiResult($result);
        } catch (ClientException $c) {
            $this->logClientException($c, 'Post Award Request failed');
        }

        return null;
    }

    /**
     * Moves the processed EDI file to archive
     *
     * @param string
     * @return void
     */
    protected function archiveProcessedFile($ediFileWithPrefix)
    {
        if (env('APP_ENV') != 'local') {
            Storage::move($ediFileWithPrefix, 'archive/' . $this->interfaceFile->uuid);
        }

        // AWS will hold it for n days, then archive to Glacier for 5 years based on the bucket's life-cycle rules
        // todo build this bucket creation and life-cycle rules in terraform
        // Transactions are intentionally stored without meaningful extensions or identifying information
    }

    /**
     * Logs an HTTP Request Client Exception
     *
     * @var GuzzleHttp\Exception\ClientException
     * @return void
     */
    protected function logClientException($exception)
    {
        Log::error('Guzzle Client Error', [
            'request' => Psr7\str($exception->getRequest()),
            'response' => $exception->hasResponse() ? Psr7\str($exception->getResponse()): null
        ]);
    }
}
