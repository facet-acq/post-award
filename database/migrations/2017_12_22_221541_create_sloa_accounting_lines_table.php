<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSloaAccountingLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sloa_accounting_lines', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->string('sub_class', 2)
                ->nullable()
                ->comment('Grouping of a transaction type; a.k.a. Sub-level Prefix');
            $table->string('department_transfer')
                ->nullable()
                ->comment('Transfer of obligation authority; a.k.a. Allocation Transfer Agency Identifier');
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
        Schema::dropIfExists('sloa_accounting_lines');
    }
}
