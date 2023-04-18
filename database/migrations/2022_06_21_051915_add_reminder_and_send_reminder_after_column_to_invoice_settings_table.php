<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReminderAndSendReminderAfterColumnToInvoiceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('invoice_settings', function (Blueprint $table) {
            $table->enum('reminder', ['after', 'every'])->after('send_reminder')->nullable();
            $table->integer('send_reminder_after')->after('reminder')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_settings', function (Blueprint $table) {
            $table->dropColumn('reminder');
            $table->dropColumn('send_reminder_after');
        });
    }

}
