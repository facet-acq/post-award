<?php

namespace App;

interface AppropriatedFundsInterface
{
    public function treasuryData();

    public function expiresInFiscalYear();

    public function accountingSystemOfRecord();

    public function funds();
}
