<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('party_assignments', function (Blueprint $table) {
            $table->uuid('party_uuid');
            $table->foreign('party_uuid')->references('uuid')->on('parties');
            $table->uuid('agreement_uuid');
            $table->foreign('agreement_uuid')->references('uuid')->on('agreements');
            $table->uuid('role_uuid');
            $table->foreign('role_uuid')->references('uuid')->on('roles');
            $table->unique(['role_uuid', 'agreement_uuid']);
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
        Schema::dropIfExists('role_assignments');
    }
}
