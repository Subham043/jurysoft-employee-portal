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
        Schema::create('ctcs', function (Blueprint $table) {
            $table->id();
            $table->string('ctc');
            $table->date('month_year', $precision = 0)->nullable();
            $table->bigInteger('hr_id')->nullable();
            $table->bigInteger('user_id');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('ctcs');
    }
};
