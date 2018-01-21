<?php

namespace App;

interface AppropriatedFundsInterface
{
    /**
     * Returns Treasury FMS reporting data required
     */
    public function treasuryData();

    /**
     * Returns the fiscal year in which the funds are no longer open for obligation
     */
    public function expiresInFiscalYear();

    /**
     * Returns the accounting station number identifying the system of record
     */
    public function accountingSystemOfRecord();

    /**
     * Returns the underlying fund tracked
     */
    public function funds();
}
