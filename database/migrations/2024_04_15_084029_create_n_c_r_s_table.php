<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('n_c_r_s', function (Blueprint $table) {
            $table->id();
            $table->string('ncr_no');
            $table->string('ref_no');
            $table->string('ncr_type');
            $table->date('issue_date');
            $table->string('chainages');
            $table->text('details');
            $table->string('status');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('n_c_r_s');
    }
};
