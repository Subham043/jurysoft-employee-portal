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
        Schema::create('employee_employment_details', function (Blueprint $table) {
            $table->id();
            $table->integer('work_status')->default(1);
            $table->bigInteger('exit_mode_id')->nullable();
            $table->string('exit_date')->nullable();
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
        Schema::dropIfExists('employee_employment_details');
    }
};
