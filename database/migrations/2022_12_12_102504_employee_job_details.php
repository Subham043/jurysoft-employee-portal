<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_job_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id')->nullable();
            $table->bigInteger('division_id')->nullable();
            $table->bigInteger('designation_id')->nullable();
            $table->bigInteger('employee_type_id')->nullable();
            $table->string('date_of_join');
            $table->string('no_of_training_days_d')->nullable();
            $table->string('no_of_training_days_m')->nullable();
            $table->string('no_of_training_days_y')->nullable();
            $table->string('training_end_date');
            $table->string('date_of_regular');
            $table->string('mou_duration_d')->nullable();
            $table->string('mou_duration_m')->nullable();
            $table->string('mou_duration_y')->nullable();
            $table->bigInteger('employee_id');
            $table->bigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_job_details');
    }
};
