<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Data payload for the API response
     *
     * @var array
     */
    protected $result = [];

    /**
     * HTTP RFC-2616 Status Code Response
     *
     * @var int
     */
    protected $statusCode = 200;

    /**
     * Error messages payload for the API response
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Documentation reference payload for the API response
     *
     * @var array
     */
    protected $docs = ['post_award' => 'https://github.com/facet-acq/post-award/wiki'];

    /**
     * Wrapper for successful API responses
     *
     * @var array $resource
     * @return \Illuminate\Http\Response
     */
    protected function respondSuccess($resource)
    {
        $this->statusCode = 200;
        $this->result = $resource;
        return $this->apiResponse();
    }

    /**
     * Wrapper for successfully created API resources
     *
     * @var array $resource
     * @return \Illuminate\Http\Response
     */
    protected function respondCreated($resource)
    {
        $this->statusCode = 201;
        $this->result = $resource;
        return $this->apiResponse();
    }

    /**
     * Wrapper for bad request response to API call
     *
     * @var string $message
     * @return \Illuminate\Http\Response
     */
    protected function respondBadRequest($message)
    {
        $this->statusCode = 400;
        $this->errors[] = 'The request was malformed';
        $this->errors[] = $message;
        return $this->apiResponse();
    }

    /**
     * Wrapper for not found response to API call
     *
     * @return \Illuminate\Http\Response
     */
    protected function respondNotFound()
    {
        $this->statusCode = 404;
        $this->errors[] = 'The requested resource was not found';
        return $this->apiResponse();
    }

    /**
     * Wrapper for failure response to API call related to preconditions
     *
     * @var string $message
     * @return \Illuminate\Http\Response
     */
    protected function respondPreconditionFailed($message)
    {
        $this->statusCode = 412;
        $this->errors[] = 'The precondition failed when tested by the server';
        $this->errors[] = $message;
        return $this->apiResponse();
    }

    /**
     * Wrapper for errors that the requested resource has not been implemented
     *
     * @var string $message
     * @return \Illuminate\Http\Response
     */
    protected function respondNotImplemented($message)
    {
        $this->statusCode = 501;
        $this->errors[] = 'This functionality is not yet implemented';
        $this->errors[] = $message;
        return $this->apiResponse();
    }

    /**
     * Wrapper to handle resourceful routing responses that will never be implemented in an API
     *
     * @return \Illuminate\Http\Response
     */
    protected function respondThisIsAnApi()
    {
        $this->statusCode = 501;
        $this->errors[] = 'This is an api, please see the docs';
        return $this->apiResponse();
    }

    /**
     * Returns a FACET Api Response
     *
     * @return \Illuminate\Http\Response
     */
    protected function apiResponse()
    {
        if (sizeof($this->errors) === 0) {
            return response()->json([
                'result' => $this->result,
                'docs' => $this->docs
            ], $this->statusCode);
        }

        return response()->json([
            'errors' => $this->errors,
            'docs' => $this->docs
        ], $this->statusCode);
    }
}
