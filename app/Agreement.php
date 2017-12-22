<?php
namespace App;

use \App\Role;
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
