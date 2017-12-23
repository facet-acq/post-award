<?php

namespace App;

abstract class AccountingLine extends UuidModel implements AppropriatedFundsInterface
{
    public function funds()
    {
        return $this->morphMany('App\Fund', 'accountable');
    }
}
