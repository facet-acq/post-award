<?php

namespace App\Http\Controllers\Api\V1\Edi;

use App\EdiInterface;
use Illuminate\Http\Request;
use App\Jobs\ProcessEdiFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ApiController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FileController extends ApiController
{
    /**
     * Holds the relative storage path to the Edi file
     *
     * @var string
     */
    protected $filePath;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respondNotImplemented('This is a work in process');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->respondThisIsAnApi();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $guardResult = $this->filePathGuard();
        if (get_class($guardResult) === 'Illuminate\Http\JsonResponse') {
            return $guardResult;
        }

        $path = $this->fetchPath($this->filePath);
        $fileToProcess = EdiInterface::create([
            'file_size' => Storage::size($this->filePath),
            'file_name' => $path[3],
            'file_type' => $path[2],
            'file_at' => Carbon::createFromTimestamp(Storage::lastModified($this->filePath), 'America/New_York'),
            'interface_partner' => $path[0],
            'interface_channel' => $path[1],
            'queued_at' => Carbon::now(),
            'processed_at' => null
        ]);
        ProcessEdiFile::dispatch($fileToProcess);
        return $this->respondCreated($fileToProcess);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        try {
            return $this->respondSuccess(EdiInterface::findOrFail($uuid));
        } catch (ModelNotFoundException $notFound) {
            return $this->respondNotFound();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return $this->respondThisIsAnApi();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        return $this->respondNotImplemented($id.' called, but this is a work in process');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->respondNotImplemented($id.' called, but this is a work in process');
    }

    /**
     * Validates that the convention for EDI file storage is honored and that the file does not come from the archive
     *
     * @param array $path
     * @return boolean
     */
    protected function isValidProcessingPath($path)
    {
        return sizeof($path) === 4 && $path[0] != 'archive';
    }

    /**
     * Provides gate for requested file
     *
     * @return mixed
     */
    protected function filePathGuard()
    {
        $requestFile = request()->only('file');
        if (sizeof($requestFile) === 1) {
            $filePath = $requestFile['file'][0];
            $path = $this->fetchPath($filePath);
            if ($this->isValidProcessingPath($path)) {
                if (Storage::exists($filePath)) {
                    $this->filePath = $filePath;
                    return null;
                }
                return $this->respondPreconditionFailed('File was not readable by the system');
            }
            return $this->respondBadRequest('Provided file fails to conform to processing convention');
        }
        return $this->respondBadRequest('The path to the file must be provided');
    }

    /**
     * Returns an array notation of the S3 prefix or directory path
     *
     * @param string $file
     * @return []
     */
    protected function fetchPath($file)
    {
        return explode('/', $file);
    }
}
