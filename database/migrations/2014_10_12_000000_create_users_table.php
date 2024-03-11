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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->string('user_name');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->nullable();
            $table->string('position')->nullable();
            $table->string('nid')->nullable();
            $table->string('photo')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
