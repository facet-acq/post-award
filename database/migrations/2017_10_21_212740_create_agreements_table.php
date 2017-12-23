<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->primary('uuid');
            $table->string('order')
                ->index()
                ->comment('Functional representation of the most basic form of an agreement.
                    Equivalent to the ANSI X12 850 ST-BEG-BEG03 Order Identifier field.');
            $table->string('release')
                ->index()
                ->nullable()
                ->comment('Functional representation of a child agreement.
                    This optional field Equivalent to the ANSI X12 850 ST-BEG-BEG04 Release Identifier field.');
            $table->datetime('effective_date')
                ->comment('Agreements go into effect at a specific date.
                    This required field holds that date.');
            $table->double('total_value');
            $table->index([
                'order',
                'release'
            ]);
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
        Schema::dropIfExists('agreements');
    }
}
