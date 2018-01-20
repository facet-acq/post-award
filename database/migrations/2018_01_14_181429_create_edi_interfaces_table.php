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
            $table->string('file_size')
                ->comment('Size in bytes of the EDI file');
            $table->string('file_name')
                ->comment('Original file name of the EDI file');
            $table->string('file_type')
                ->comment('Data type of the EDI file');
            $table->dateTimeTz('file_at')
                ->comment('File timestamp of the EDI file, always generated in UTC');
            $table->string('interface_partner')
                ->comment("Data owner of the EDI file's source");
            $table->string('interface_channel')
                ->comment('System in which the EDI file was generated');
            $table->string('interface_version')
                ->nullable()
                ->comment('Standard against which the EDI file was generated');
            $table->string('interface_source')
                ->nullable()
                ->comment('EDI file declared generation source');
            $table->string('interface_destination')
                ->nullable()
                ->comment('EDI file declared destination');
            $table->bigInteger('interface_control_number')
                ->nullable()
                ->comment('Unique or identifying control number for the EDI file');
            $table->dateTimeTz('interface_at')
                ->nullable()
                ->comment('Timestamp at which the transaction interface was created in the file payload');
            $table->dateTimeTz('queued_at')
                ->comment('Timestamp at which the file was queued for processing supporting metrics');
            $table->dateTimeTz('processed_at')
                ->nullable()
                ->comment('Timestamp at which the file was processed from the queue');
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
