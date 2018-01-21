<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->primary('uuid');
            $table->uuid('agreement_uuid')->comment('UUID identifier for the agreement to which the item belongs');
            $table->foreign('agreement_uuid')->references('uuid')->on('agreements');
            $table->string('item_identifier');
            $table->float('quantity');
            $table->float('unit_cost');
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
        Schema::dropIfExists('items');
    }
}
