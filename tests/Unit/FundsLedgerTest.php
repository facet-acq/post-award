<?php

namespace Tests\Unit;

use App\Agreement;
use App\LedgerEntry;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\SloaAccountingLine;

class FundsLedgerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_records_an_obligation_from_an_agreement()
    {
        // Given an agreement and an accounting line
        $agreement = factory(Agreement::class)->create();
        $sloa = factory(SloaAccountingLine::class)->create();
        $fund = $sloa->funds->first();
        $amount = 45000;

        $ledgerEntry = $fund->obligate($amount, $agreement->uuid);

        $this->assertCount(1, LedgerEntry::all());
        $this->assertEquals($amount, $ledgerEntry->obligation);
        $this->assertDatabaseHas('ledger_entries', [
            'fund_uuid' => $fund->uuid,
            'agreement_uuid' => $agreement->uuid,
            'item_uuid' => null,
            'voucher_uuid' => null,
            'description' => 'Initial Obligation of Funds',
            'obligation' => $amount,
            'expense' => 0,
            'disbursement' => 0
        ]);
    }
}
