<?php

namespace App;

class LedgerEntry extends UuidModel
{
    /**
     * Set mass assignment permissions for ledger entries
     */
    protected $fillable = [
        'fund_uuid',
        'agreement_uuid',
        'item_uuid',
        'voucher_uuid',
        'description',
        'obligation',
        'expense',
        'disbursement'
    ];

    /**
     * Identifies the fund impacted by the ledger entry
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fund()
    {
        return $this->belongsTo('App\Fund');
    }
}
