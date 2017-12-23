<?php
namespace App;

use \App\Role;

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

    public function parties()
    {
        return $this->belongsToMany(Party::class, 'party_assignments', 'agreement_uuid', 'party_uuid')->withTimestamps();
    }

    public function buyer()
    {
        return $this->parties()->wherePivot('role_uuid', Role::where('description', 'buyer')->first()->uuid);
    }

    public function seller()
    {
        return $this->parties()->wherePivot('role_uuid', Role::where('description', 'seller')->first()->uuid);
    }

    public function addBuyer($buyer)
    {
        $this->parties()->attach($buyer, ['role_uuid' => Role::where('description', 'buyer')->first()->uuid]);
        $this->save();
        return $this;
    }

    public function addSeller($seller)
    {
        $this->parties()->attach($seller, ['role_uuid' => Role::where('description', 'seller')->first()->uuid]);
        $this->save();
        return $this;
    }
}
