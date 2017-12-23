<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SloaAccountingLine extends AccountingLine
{
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
