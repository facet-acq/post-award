<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSloaFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sloa_funds', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->string('sub_class', 2)
                ->nullable()
                ->comment('Grouping of a transaction type aka Sub-level Prefix');
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
        Schema::dropIfExists('sloa_funds');
    }
}
