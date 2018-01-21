<?php

namespace App;

class Fund extends UuidModel
{
    /**
     * References any type of accounting line to the fund itself
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function accountable()
    {
        return $this->morphTo();
    }

    /**
     * References the accounting ledger for action entries related to the fund
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ledgerEntries()
    {
        return $this->hasMany('App\LedgerEntry', 'fund_uuid');
    }

    /**
     * Create an initial obligation action for the ledger
     *
     * @return App\LedgerEntry
     */
    public function obligate($amount, $agreementUuid)
    {
        return $this->ledgerEntries()
            ->create([
                'agreement_uuid' => $agreementUuid,
                'description' => 'Initial Obligation of Funds',
                'obligation' => $amount
            ]);
    }

    /**
     * Calculates current ledger balances for a fund across all agreements
     *
     * @return Illuminate\Support\Collection
     */
    public function balance()
    {
        $ledgerData = $this->ledgerEntries();

        return collect([
            'obligation' => $ledgerData->sum('obligation'),
            'expense' => $ledgerData->sum('expense'),
            'disbursement' => $ledgerData->sum('disbursement')
        ]);
    }

    /**
     * Returns the items to which this fund is tied
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany('App\Item', 'fund_item_assignment', 'fund_uuid', 'item_uuid')
            ->withPivot('amount')
            ->withTimestamps();
    }
}
