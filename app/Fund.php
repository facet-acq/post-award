<?php

namespace App;

class Fund extends UuidModel
{
    public function accountable()
    {
        return $this->morphTo();
    }

    public function ledgerEntries()
    {
        return $this->hasMany('App\LedgerEntry', 'fund_uuid');
    }

    public function obligate($amount, $agreementUuid)
    {
        return $this->ledgerEntries()
            ->create([
                'agreement_uuid' => $agreementUuid,
                'description' => 'Initial Obligation of Funds',
                'obligation' => $amount
            ]);
    }

    public function balance()
    {
        $ledgerData = $this->ledgerEntries();

        return collect([
            'obligation' => $ledgerData->sum('obligation'),
            'expense' => $ledgerData->sum('expense'),
            'disbursement' => $ledgerData->sum('disbursement')
        ]);
    }

    public function items()
    {
        return $this->belongsToMany('App\Item', 'fund_item_assignment', 'fund_uuid', 'item_uuid')
            ->withPivot('amount')
            ->withTimestamps();
    }
}
