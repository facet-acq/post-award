<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class UuidModel extends Model
{
    /**
    * Inform the eloquent model that we are using UUID-4s not incrementing counts
    *
    * @var boolean
    */
    public $incrementing = false;

    /**
     * Sets the name of the primary key for Eloquent
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * Sets the type of the key for Eloquent
     *
     * @var string
     */
    protected $keyType = 'uuid';

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
    * @return string
    */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
    * Getter to integrate uuid value into Eloquent functionality
    *
    * @return string
    */
    public function getKeyName()
    {
        return 'uuid';
    }

    /**
     * Getter to disable automatic incrementing values in Eloquent models
     *
     * @return boolean
     */
    public function getIncrementing()
    {
        return false;
    }
}
