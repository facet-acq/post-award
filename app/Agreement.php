<?php

namespace App;

class Agreement extends UuidModel
{
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
     * Accesses the line items related to the agreement
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Item', 'uuid');
    }

    /**
     * Accesses the parties related to the agreement
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parties()
    {
        return $this->belongsToMany(Party::class, 'party_assignments', 'agreement_uuid', 'party_uuid')->withTimestamps();
    }

    /**
     * Accesses the buyer related to the agreement
     *
     * @return App\Party
     */
    public function buyer()
    {
        return $this->parties()->wherePivot('role_uuid', Role::where('description', 'buyer')->first()->uuid);
    }

    /**
     * Accesses the seller related to the agreement
     *
     * @return App\Party
     */
    public function seller()
    {
        return $this->parties()->wherePivot('role_uuid', Role::where('description', 'seller')->first()->uuid);
    }

    /**
     * Fluently adds a Buyer to the Agreement
     *
     * @return App\Agreement
     */
    public function addBuyer($buyer)
    {
        $this->parties()->attach($buyer, ['role_uuid' => Role::where('description', 'buyer')->first()->uuid]);
        $this->save();
        return $this;
    }

    /**
     * Fluently adds a Seller to the Agreement
     *
     * @return App\Agreement
     */
    public function addSeller($seller)
    {
        $this->parties()->attach($seller, ['role_uuid' => Role::where('description', 'seller')->first()->uuid]);
        $this->save();
        return $this;
    }
}
