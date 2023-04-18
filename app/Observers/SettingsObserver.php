<?php

namespace App\Observers;

use App\Http\Controllers\AppSettingController;
use App\Models\Setting;
use App\Models\User;

class SettingsObserver
{

    public function saving(Setting $setting)
    {

        session()->forget('global_setting');

        $user = user();

        if ($user) {
            $setting->last_updated_by = $user->id;
        }

        if ($setting->isDirty('date_format')) {

            switch ($setting->date_format) {

            case 'd-m-Y':
                    $setting->date_picker_format = 'dd-mm-yyyy';
                    $setting->moment_format = 'DD-MM-YYYY';
                    break;
            case 'm-d-Y':
                    $setting->date_picker_format = 'mm-dd-yyyy';
                    $setting->moment_format = 'MM-DD-YYYY';
            case 'Y-m-d':
                    $setting->date_picker_format = 'yyyy-mm-dd';
                    $setting->moment_format = 'YYYY-MM-DD';
                    break;
            case 'd.m.Y':
                    $setting->date_picker_format = 'dd.mm.yyyy';
                    $setting->moment_format = 'DD.MM.YYYY';
                    break;
            case 'm.d.Y':
                    $setting->date_picker_format = 'mm.dd.yyyy';
                    $setting->moment_format = 'MM.DD.YYYY';
                    break;
            case 'Y.m.d':
                    $setting->date_picker_format = 'yyyy.mm.dd';
                    $setting->moment_format = 'YYYY.MM.DD';
                    break;
            case 'd/m/Y':
                    $setting->date_picker_format = 'dd/mm/yyyy';
                    $setting->moment_format = 'DD/MM/YYYY';
                    break;
            case 'Y/m/d':
                    $setting->date_picker_format = 'yyyy/mm/dd';
                    $setting->moment_format = 'YYYY/MM/DD';
                    break;
            case 'd-M-Y':
                    $setting->date_picker_format = 'dd-M-yyyy';
                    $setting->moment_format = 'DD-MMM-YYYY';
                    break;
            case 'd/M/Y':
                    $setting->date_picker_format = 'dd/M/yyyy';
                    $setting->moment_format = 'DD/MMM/YYYY';
                    break;
            case 'd.M.Y':
                    $setting->date_picker_format = 'dd.M.yyyy';
                    $setting->moment_format = 'DD.MMM.YYYY';
                    break;
            case 'd M Y':
                    $setting->date_picker_format = 'dd M yyyy';
                    $setting->moment_format = 'DD MMM YYYY';
                    break;
            case 'd F, Y':
                    $setting->date_picker_format = 'dd MM, yyyy';
                    $setting->moment_format = 'yyyy-mm-d';
                    break;
            case 'd D M Y':
                    $setting->date_picker_format = 'dd D M yyyy';
                    $setting->moment_format = 'DD ddd MMM YYYY';
                    break;
            case 'D d M Y':
                    $setting->date_picker_format = 'D dd M yyyy';
                    $setting->moment_format = 'ddd DD MMMM YYYY';
                    break;
            default:
                    $setting->date_picker_format = 'mm/dd/yyyy';
                    $setting->moment_format = 'DD-MM-YYYY';
                    break;
            }

        }

        if (!isRunningInConsoleOrSeeding() && $setting->isDirty('currency_id')) {
            $allClients = User::allClients();
            $clientsArray = $allClients->pluck('id')->toArray();

            $appSettings = new AppSettingController();
            $appSettings->deleteSessions($clientsArray);
        }
    }

}
