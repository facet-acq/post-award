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
            $table->uuid('fund_uuid')->index();
            $table->uuid('agreement_uuid');
            $table->index(['fund_uuid', 'agreement_uuid']);
            $table->uuid('item_uuid')->nullable();
            $table->uuid('voucher_uuid')->nullable();
            $table->string('description');
            $table->double('obligation')->default(0);
            $table->double('expense')->default(0);
            $table->double('disbursement')->default(0);
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
