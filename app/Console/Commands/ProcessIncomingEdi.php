<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\EdiInterface;
use App\Jobs\ProcessEdiFile;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\RequestException;

class ProcessIncomingEdi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'edi:enqueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue all incoming EDI files in the bucket';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // List all files on the drive
        $workList = Storage::allFiles();

        // Loop each file and parse it into a usable object
        foreach ($workList as $ediFile) {
            $path = explode('/', $ediFile);
            if (sizeof($path) === 4 && $path[0] != 'archive') {
                $this->enqueueEdiFile($ediFile);
            }
        }

        $this->info('Enqueue complete');
    }

    /**
     * Wraps the POST action of an interface file to the REST endpoint for processing
     *
     * @param string $file
     * @return array
     */
    protected function enqueueEdiFile($file)
    {
        $client = new Client();
        $headers = ['Content-Type' => 'application/json'];
        $body = json_encode(['file' => [$file]]);

        $request = new Request('POST', $this->getFileUrl(), $headers, $body);
        $response = $client->send($request);

        if ($response->getStatusCode() == 201) {
            $responseBody = json_decode($response->getBody()->read(2048), true);
            return $responseBody['result'];
        }
    }

    /**
     * Retrieves the file processing endpoint URL from config file
     *
     * @return string
     */
    protected function getFileUrl()
    {
        return config('post-award.edi.file_processing.url') . 'interface/file';
    }
}
