<?php

namespace App;

class Item extends UuidModel
{
    /**
     * Associates line items for the agreement to which they belong
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agreement()
    {
        return $this->belongsTo('App\Agreement', 'agreement_uuid');
    }

    /**
     * Associates the item to related funds
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function funds()
    {
        return $this->belongsToMany('App\Fund', 'fund_item_assignment', 'item_uuid', 'fund_uuid')
            ->withPivot('amount')
            ->withTimestamps();
    }

    /**
     * Computes the total amount funded for the item
     *
     * @return double
     */
    public function totalFunded()
    {
        return $this->funds()->sum('amount');
    }

    /**
     * Computes the total cost for the item
     *
     * @return double
     */
    public function totalCost()
    {
        return $this->quantity * $this->unit_cost;
    }
}
