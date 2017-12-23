<?php

namespace App;

use \App\Traits\IdentifyByUuid;
use Illuminate\Database\Eloquent\Model;

abstract class UuidModel extends Model
{
    use IdentifyByUuid;

    /**
    * Inform the eloquent model that we are using UUID-4s not incrementing counts
    *
    * @var boolean
    */
    public $incrementing = false;
}
