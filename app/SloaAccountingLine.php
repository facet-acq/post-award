<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SloaAccountingLine extends UuidModel implements AppropriatedFundsInterface
{
    public function funds()
    {
        return $this->morphMany('App\Fund', 'accountable');
    }

    public function treasuryData()
    {
        return null;
    }

    public function expiresInFiscalYear()
    {
        return null;
    }

    public function accountingStation()
    {
        return null;
    }
}
