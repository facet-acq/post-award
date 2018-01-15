<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdiInterfacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edi_interfaces', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->primary('uuid');
            $table->uuid('agreement');
            $table->string('file_size');
            $table->string('file_name');
            $table->string('file_type');
            $table->dateTimeTz('file_at');
            $table->string('interface_partner');
            $table->string('interface_channel');
            $table->string('interface_version');
            $table->string('interface_source');
            $table->string('interface_destination');
            $table->bigInteger('interface_control_number');
            $table->dateTimeTz('interface_at');
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
        Schema::dropIfExists('edi_interfaces');
    }
}
