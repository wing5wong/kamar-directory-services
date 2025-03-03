<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pastorals', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID.
            $table->string('student_id');
            $table->string('nsn')->nullable(); // School index number(s), can be blank or multiple.
            $table->enum('type', ['G', 'A', 'D', 'C', 'U', 'O']); // Category type of the record (G = Guidance, A = Attendance, etc.)
            $table->integer('ref')->unsigned(); // Numeric sequential identifier for the record.
            $table->text('reason')->nullable(); // Reason for the record (misbehavior, etc.)
            $table->string('reasonPB')->nullable(); // PB4L category for the reason.
            $table->text('motivation')->nullable(); // The "why" for the incident.
            $table->string('motivationPB')->nullable(); // PB4L category for motivation.
            $table->text('location')->nullable(); // Where the incident occurred.
            $table->string('locationPB')->nullable(); // PB4L category for location.
            $table->text('othersinvolved')->nullable(); // Others involved in the incident.
            $table->text('action1')->nullable(); // First consequence.
            $table->text('action2')->nullable(); // Second consequence.
            $table->text('action3')->nullable(); // Third consequence.
            $table->string('actionPB1')->nullable(); // PB4L category for action1.
            $table->string('actionPB2')->nullable(); // PB4L category for action2.
            $table->string('actionPB3')->nullable(); // PB4L category for action3.
            $table->string('teacher')->nullable(); // Teacher associated with the record.
            $table->integer('points')->nullable(); // Points earned (positive value).
            $table->integer('demerits')->nullable(); // Demerits earned (punitive value).
            $table->date('dateevent')->nullable(); // Date the event occurred (YYYYMMDD).
            $table->time('timeevent')->nullable(); // Time the event occurred (HHMMSS).
            $table->date('datedue')->nullable(); // Due date for action completion.
            $table->string('duestatus')->nullable(); // Status of the action (Incomplete, Completed, etc.).
            $table->timestamps(); // Created and updated timestamps.
        });
    }
};
