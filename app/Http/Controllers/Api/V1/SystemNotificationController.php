<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Events\SystemWideNotification;

class SystemNotificationController extends ApiController
{
    /**
     * Dispatches a system wide websocket notification
     */
    public function create()
    {
        $message = request()->input('message', 'This is a test of the system wide notification system. This is only a test.');

        SystemWideNotification::dispatch($message);

        return $this->respondSuccess('It should have worked');
    }
}
