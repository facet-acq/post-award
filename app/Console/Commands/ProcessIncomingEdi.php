<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\EdiInterface;
use App\Jobs\ProcessEdiFile;
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
            $this->enqueueEdiFile($ediFile);
        }

        $this->info('Enqueue complete');
    }

    protected function enqueueEdiFile($file)
    {
        // extract original file data and save to trading partners table
        $path = explode('/', $file);
        if (sizeof($path) === 4 && $path[0] != 'archive') {
            $fileToProcess = EdiInterface::create([
                'file_size' => Storage::size($file),
                'file_name' => $path[3],
                'file_type' => $path[2],
                'file_at' => Carbon::createFromTimestamp(Storage::lastModified($file), 'America/New_York'),
                'interface_partner' => $path[0],
                'interface_channel' => $path[1],
                'queued_at' => Carbon::now(),
                'processed_at' => null
            ]);
            ProcessEdiFile::dispatch($fileToProcess);
        }
    }
}
