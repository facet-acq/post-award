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
            $table->increments('id');
            $table->uuid('party_uuid');
            $table->uuid('agreement_uuid');
            $table->uuid('role_uuid');
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
