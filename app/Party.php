<?php

namespace App;

class Party extends UuidModel
{
    /**
     * Returns agreements assocaited to the party
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function agreements()
    {
        return $this->belongsToMany('App\Agreement', 'party_assignments', 'party_uuid', 'agreement_uuid');
    }
}
