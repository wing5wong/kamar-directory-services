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
        Schema::create('staff', function (Blueprint $table) {
            $table->increments('id');
            $table->string('staff_id')->unique();
            $table->uuid('uuid')->unique(); // UUID for the student record.
            $table->string('role')->default('Staff'); // Always set to 'Student'.
            $table->json('schoolindex'); // School index number ([1..5,...]).
            $table->datetime('created')->nullable();
            $table->string('uniqueid')->nullable(); // School-editable unique ID number.
            $table->string('username')->nullable(); // Logon Username.
            $table->string('title')->nullable(); // Preferred first name.
            $table->string('firstname')->nullable(); // Preferred first name.
            $table->string('lastname')->nullable(); // Preferred last name.
            $table->enum('gender', ['M', 'F'])->nullable(); // Gender (M or F).
            $table->date('datebirth')->nullable(); // Date of Birth (YYYYMMDD).
            $table->string('tutor')->nullable(); // Tutor class.
            $table->string('house')->nullable(); // House (e.g., school house).
            $table->string('photocoperid')->nullable(); // Photocopier system ID.
            $table->date('startingdate')->nullable(); // Date student started at this school.
            $table->date('leavingdate')->nullable(); // Date student left (if applicable).
            $table->string('email')->nullable(); // School email address.
            $table->string('mobile')->nullable(); // Mobile number.
            $table->string('extension')->nullable(); // Extension number.
            $table->json('groups')->nullable(); // List of teams/groups and timetable classes.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
