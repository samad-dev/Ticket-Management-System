<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowClockInButtonInAttendaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('attendance_settings', function (Blueprint $table) {
            $table->enum('show_clock_in_button', ['yes', 'no'])->default('no')->after('allow_shift_change');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_settings', function (Blueprint $table) {
                $table->dropColumn(['show_clock_in_button']);
        });
    }

}
