<?php

namespace App\Observers;

use App\SloaAccountingLine;

class SloaAccountingLineObserver
{
    /**
     * Listen to the AccountingLine created event.
     *
     * @param \App\SloaAccountingLine $accountingLine
     * @return void
     */
    public function created(SloaAccountingLine $accountingLine)
    {
        $accountingLine->funds()->create();
    }
}
