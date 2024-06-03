<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClockinClockoutLocationToAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->time('clockin')->nullable();
            $table->time('clockout')->nullable();
            $table->string('clockin_location')->nullable();
            $table->string('clockout_location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['clockin', 'clockout', 'clockin_location','clockout_location']);
        });
    }
}
