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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID.
            $table->string('student_id'); // National Student Number.
            $table->string('nsn'); // National Student Number.
            $table->date('date'); // Date of attendance (YYYYMMDD).
            $table->string('codes'); // Raw attendance data (one for each time slot, dots for unused).
            $table->string('alt'); // Ministry of Education's truancy codes (one for each time slot).
            $table->integer('hdu')->default(0); // Count of half days for unjustified absences.
            $table->integer('hdj')->default(0); // Count of half days for justified absences.
            $table->integer('hdp')->default(0); // Count of half days present.
            $table->timestamps(); // Created and updated timestamps.
        });
    }
};
