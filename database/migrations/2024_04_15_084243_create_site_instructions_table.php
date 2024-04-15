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
        Schema::create('site_instructions', function (Blueprint $table) {
            $table->id();
            $table->string('si_no')->nullable();
            $table->string('ref_no')->nullable();
            $table->string('si_type')->nullable();
            $table->date('issue_date')->nullable();
            $table->string('chainages')->nullable();
            $table->string('details')->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_instructions');
    }
};
