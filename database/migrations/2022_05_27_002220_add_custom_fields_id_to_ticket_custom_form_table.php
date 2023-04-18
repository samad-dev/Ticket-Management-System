<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomFieldsIdToTicketCustomFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::table('ticket_custom_forms', function (Blueprint $table) {
            $table->unsignedInteger('custom_fields_id')->after('id')->nullable();
            $table->foreign('custom_fields_id')->references('id')->on('custom_fields')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_custom_forms', function (Blueprint $table) {
            $table->dropForeign(['custom_fields_id']);
            $table->dropColumn(['custom_fields_id']);
        });
    }

}
