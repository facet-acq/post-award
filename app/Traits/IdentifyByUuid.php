<?php

namespace App\Traits;

trait IdentifyByUuid
{
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
