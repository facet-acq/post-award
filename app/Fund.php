<?php

namespace App;

class Fund extends UuidModel
{
    protected $fillable = [
        'amount'
    ];

    public function accountable()
    {
        return $this->morphTo();
    }
}
