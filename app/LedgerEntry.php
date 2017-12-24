<?php

namespace App;

class LedgerEntry extends UuidModel
{
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

    public function fund()
    {
        return $this->belongsTo('App\Fund');
    }
}
