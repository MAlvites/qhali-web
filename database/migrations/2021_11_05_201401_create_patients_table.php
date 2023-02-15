<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('mother_last_name')->nullable();
            $table->string('nin');
            $table->integer('age');
            $table->date('date_birth');
            $table->string('civil_status');
            $table->string('birth_sex');
            $table->string('sex_orientation');
            $table->string('academic_level');
            $table->string('profession');
            $table->string('employment_situation');
            $table->string('address');
            $table->string('district');
            $table->string('phone_number');
            $table->string('email');
            $table->integer('has_medic_history')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
