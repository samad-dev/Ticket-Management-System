<?php

use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultStatusInCalendarViewEmployeeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('employee_details', function (Blueprint $table)
        {
            $employees = EmployeeDetails::all();

            foreach ($employees as $employee)
            {
                $employee->calendar_view = 'task,events,holiday,tickets,leaves';
                $employee->save();
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    
    public function down()
    {
        Schema::table('employee_details', function (Blueprint $table)
        {
            $employees = EmployeeDetails::all();

            foreach ($employees as $employee)
            {
                $employee->calendar_view = null;
                $employee->save();
            }
        });
    }

}
