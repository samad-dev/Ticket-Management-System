<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShiftTimeColumnsAttendanceTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dateTime('shift_start_time')->nullable();
            $table->dateTime('shift_end_time')->nullable();
            $table->bigInteger('employee_shift_id')->unsigned()->nullable();
            $table->foreign('employee_shift_id')->references('id')->on('employee_shifts')->onDelete('SET NULL')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['shift_start_time']);
            $table->dropColumn(['shift_end_time']);
            $table->dropForeign(['employee_shift_id']);
            $table->dropColumn(['employee_shift_id']);
        });
    }

}
