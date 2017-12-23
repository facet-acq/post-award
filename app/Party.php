<?php

namespace App;

class Party extends UuidModel
{
    public function agreements()
    {
        return $this->belongsToMany('App\Agreement', 'party_assignments', 'party_uuid', 'agreement_uuid');
    }
}
