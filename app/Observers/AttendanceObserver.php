<?php

namespace App\Observers;

use App\Models\Attendance;
use App\Models\AttendanceSetting;
use App\Models\EmployeeShiftSchedule;
use Carbon\Carbon;

class AttendanceObserver
{

    public function saving(Attendance $attendance)
    {
        if (user()) {
            $attendance->last_updated_by = user()->id;
        }
    }

    public function creating(Attendance $attendance)
    {
        if (user()) {
            $attendance->added_by = user()->id;
        }
    }

}
