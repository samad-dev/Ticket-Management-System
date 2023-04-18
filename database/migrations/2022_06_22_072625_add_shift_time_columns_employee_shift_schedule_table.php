<?php

use App\Models\EmployeeShiftSchedule;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShiftTimeColumnsEmployeeShiftScheduleTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_shift_schedules', function (Blueprint $table) {
            $table->dateTime('shift_start_time')->nullable();
            $table->dateTime('shift_end_time')->nullable();
        });

        $existingSchedules = EmployeeShiftSchedule::whereDate('date', '>=', now()->subDay()->toDateString())->get();

        if ($existingSchedules) {
            foreach ($existingSchedules as $item) {
                $item->shift_start_time = $item->date->toDateString() . ' ' .$item->shift->office_start_time;

                if (Carbon::parse($item->shift->office_start_time)->gt(Carbon::parse($item->shift->office_end_time))) {
                    $item->shift_end_time = $item->date->addDay()->toDateString() . ' ' . $item->shift->office_end_time;
        
                } else {
                    $item->shift_end_time = $item->date->toDateString() . ' ' .$item->shift->office_end_time;
                }

                $item->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_shift_schedules', function (Blueprint $table) {
            $table->dropColumn(['shift_start_time']);
            $table->dropColumn(['shift_end_time']);
        });
    }

}
