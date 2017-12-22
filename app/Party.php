<?php

namespace App;

use \App\Traits\IdentifyByUuid;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use IdentifyByUuid;

    /**
    * Inform the eloquent model that we are using UUID-4s not incrementing counts
    *
    * @var boolean
    */
    public $incrementing = false;

    public function agreements()
    {
        return $this->belongsToMany('App\Agreement', 'party_assignments', 'party_uuid', 'agreement_uuid');
    }
}
