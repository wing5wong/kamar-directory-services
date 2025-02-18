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
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('student_id')->unique();
            $table->uuid('uuid')->unique(); // UUID for the student record.
            $table->string('role')->default('Student'); // Always set to 'Student'.
            $table->integer('schoolindex')->unsigned(); // School index number (1-5).
            $table->string('nsn')->nullable(); // National Student Number (NSI / NSN).
            $table->datetime('created')->nullable();
            $table->string('uniqueid')->nullable(); // School-editable unique ID number.
            $table->boolean('accountdisabled')->default(false); // Account disabled flag (0 or 1).
            $table->boolean('signedagreement')->default(false); // Flag for signed internet agreement.
            $table->text('byodinfo')->nullable(); // BYOD notes.
            $table->string('username')->nullable(); // Logon Username.
            $table->string('firstname')->nullable(); // Preferred first name.
            $table->string('lastname')->nullable(); // Preferred last name.
            $table->enum('gender', ['M', 'F'])->nullable(); // Gender (M or F).
            $table->enum('genderpreferred', ['M', 'F', 'D'])->nullable(); // Preferred gender (M, F, D).
            $table->enum('gendercode', [11, 21, 30, 31, 32, 33])->nullable(); // Gender code.
            $table->string('ethnicityL1')->nullable(); // Level 1 Ethnicity (6 categories).
            $table->string('ethnicityL2')->nullable(); // Level 2 Ethnicity (18 categories).
            $table->json('ethnicity')->nullable(); // Level 4 Ethnicity (array up to 3 ethnicities).
            $table->json('iwi')->nullable(); // MoE Code List (array of up to 3 iwi).
            $table->string('siblinglink')->nullable(); // Unique number linking the student to their siblings.
            $table->boolean('boarder')->default(false); // Flag indicating if the student is a boarder.
            $table->date('datebirth')->nullable(); // Date of Birth (YYYYMMDD).
            $table->integer('yearlevel')->unsigned()->nullable(); // Current year level (1 to 13).
            $table->integer('fundinglevel')->unsigned()->nullable(); // Funding year level (0 to 15).
            $table->string('moetype')->nullable(); // MoE Type (e.g., RE = Regular Student).
            $table->string('ece')->nullable(); // Early childhood education code.
            $table->enum('ors', ['N', 'H', 'V', 'S'])->nullable(); // ORS Funding.
            $table->boolean('esol')->default(false); // ESOL status (boolean).
            $table->string('languagespoken', 3)->nullable(); // 3-character code for language spoken.
            $table->string('tutor')->nullable(); // Tutor class.
            $table->string('house')->nullable(); // House (e.g., school house).
            $table->string('whanau')->nullable(); // Whanau (different from tutor).
            $table->json('timetabletop')->nullable(); // Top 4 timetable classes (highest priority).
            $table->json('timetablebottom')->nullable(); // Bottom 4 timetable classes (lowest priority).
            $table->string('photocoperid')->nullable(); // Photocopier system ID.
            $table->date('startschooldate')->nullable(); // Start date at school (age 5).
            $table->date('startingdate')->nullable(); // Date student started at this school.
            $table->date('leavingdate')->nullable(); // Date student left (if applicable).
            $table->string('leavingreason', 1)->nullable(); // Leaving reason (MoE defined, 1 character).
            $table->string('leavingactivity', 2)->nullable(); // Leaving activity (2-digit MoE defined).
            $table->json('leavingschools')->nullable(); // Leaving schools (array of up to 6 schools).
            $table->string('email')->nullable(); // School email address.
            $table->string('mobile')->nullable(); // Mobile number.
            $table->boolean('networkaccess')->default(1); // Internet access allowed (0 or 1).
            $table->string('althomedrive')->nullable(); // Alternate network home drive location.
            $table->string('altdescription')->nullable(); // Alternate network user description.
            $table->json('residences')->nullable(); // Information about the student's residence.
            $table->json('caregivers')->nullable(); // List of caregivers associated with the student.
            $table->json('groups')->nullable(); // List of teams/groups and timetable classes.
            $table->json('awards')->nullable(); // List of student awards.
            $table->json('datasharing')->nullable(); // Student data sharing preferences.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
