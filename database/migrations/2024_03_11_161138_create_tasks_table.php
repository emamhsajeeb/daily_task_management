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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('number')->nullable();
            $table->string('type');
            $table->text('description');
            $table->string('location');
            $table->string('side')->nullable();;
            $table->string('qty_layer')->nullable();;
            $table->string('planned_time');
            $table->string('incharge')->nullable();
            $table->string('status')->nullable();
            $table->string('completion_time')->nullable();
            $table->text('inspection_details')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
