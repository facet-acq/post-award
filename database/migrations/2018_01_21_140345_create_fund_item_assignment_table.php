<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundItemAssignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_item_assignment', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('fund_uuid')
                ->comment('Lookup key for a fund');
            $table->uuid('item_uuid')
                ->comment('Lookup key for an item within an agreement');
            $table->double('amount')
                ->comment('Amount of a fund attached to the referenced line item as a do not exceed threshold');
            $table->foreign('fund_uuid')
                ->references('uuid')
                ->on('funds');
            $table->foreign('item_uuid')
                ->references('uuid')
                ->on('items');
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
        Schema::dropIfExists('fund_item_assignment');
    }
}
