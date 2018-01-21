<?php

namespace App;

class Item extends UuidModel
{
    public function agreement()
    {
        return $this->belongsTo('App\Agreement', 'agreement_uuid');
    }

    public function funds()
    {
        return $this->belongsToMany('App\Fund', 'fund_item_assignment', 'item_uuid', 'fund_uuid')
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function totalFunded()
    {
        return $this->funds()->sum('amount');
    }

    public function totalCost()
    {
        return $this->quantity * $this->unit_cost;
    }
}
