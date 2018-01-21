<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLedgerEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledger_entries', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->primary('uuid');
            $table->uuid('fund_uuid')
                ->comment('Pointer to the Fund impacted by the ledger entry');
            $table->uuid('agreement_uuid')
                ->comment('Pointer to the Agreement impacted by the ledger entry');
            $table->index(['fund_uuid', 'agreement_uuid']);
            $table->uuid('item_uuid')
                ->nullable()
                ->comment('Pointer to the item impacted by the ledger entry');
            $table->uuid('voucher_uuid')
                ->nullable()
                ->comment('Pointer to the voucher impacted by the ledger entry');
            $table->string('description');
            $table->double('obligation')
                ->default(0)
                ->comment('Amount of capital obligated for payment to a vendor in return for a good or service');
            $table->double('expense')
                ->default(0)
                ->comment('Amount of capital earned by the vendor and available for payout');
            $table->double('disbursement')
                ->default(0)
                ->comment('Amount of capital verified as paid out by one or more vouchers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ledger_entries');
    }
}
