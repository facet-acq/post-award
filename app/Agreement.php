<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
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
     * Inform the eloquent model that we are using UUID-4s not incrementing counts
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Setup model event hooks
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) \Uuid::generate(4);
        });
    }

    /**
     * Setup route model binding for UUID
     *
     * @return void
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Getter to integrate uuid value into Eloquent functionality
     *
     * @return void
     */
    public function getKeyName()
    {
        return 'uuid';
    }
}
