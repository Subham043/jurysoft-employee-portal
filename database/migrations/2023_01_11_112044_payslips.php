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
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->string('main_gross_salary');
            $table->string('month_year');
            $table->string('total_days_of_month');
            $table->string('working_days_of_month');
            $table->string('paid_leave_taken');
            $table->string('unpaid_leave_taken');
            $table->string('worked_days');
            $table->bigInteger('user_id');
            $table->integer('working_days_of_month_arrears')->default(0);
            $table->integer('unpaid_leave_taken_arrears')->default(0);
            $table->integer('allow_arrears')->default(0);
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
        Schema::dropIfExists('payslips');
    }
};
