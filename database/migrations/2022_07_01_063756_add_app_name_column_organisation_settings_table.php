<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppNameColumnOrganisationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('organisation_settings', function(Blueprint $table){
            $table->string('app_name')->nullable()->after('company_name');
        });

        $companySettings = Setting::first();

        if($companySettings) {
            $companySettings->app_name = $companySettings->company_name;
            $companySettings->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {
        Schema::table('organisation_settings', function(Blueprint $table){
            $table->dropColumn(['app_name']);
        });
    }
    
}
