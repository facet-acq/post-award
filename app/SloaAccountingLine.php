<?php

namespace App;

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

    public function accountingSystemOfRecord()
    {
        return $this->agency_accounting_identifier;
    }
}
