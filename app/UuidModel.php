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

    public function getIncrementing()
    {
        return false;
    }

    /**
     * Sets the name of the primary key for Eloquent
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * Sets the type of the key for Eloquent
     *
     * @var string
     */
    protected $keyType = 'uuid';
}
