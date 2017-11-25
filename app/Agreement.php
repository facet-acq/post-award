<?php

namespace App;

use \App\Traits\IdentifyByUuid;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use IdentifyByUuid;

    /**
     * Documents Mass Assignment Properties
     *
     * @var array
     */
    protected $fillable = [
        'order',
        'release',
        'effective_date',
        'total_value'
    ];

    /**
     * Inform the eloquent model that we are using UUID-4s not incrementing counts
     *
     * @var boolean
     */
    public $incrementing = false;


    public function addBuyer($buyer)
    {
        $this->buyer()->associate($buyer);
        $this->save();
        return $this;
    }

    public function buyer()
    {
        return $this->belongsTo(Party::class);
    }

    public function seller()
    {
        return $this->belongsTo(Party::class);
    }

    public function addSeller($seller)
    {
        $this->seller()->associate($seller);
        $this->save();
        return $this;
    }
}
