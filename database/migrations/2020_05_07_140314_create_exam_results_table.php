<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->string('department')->nullable();
            $table->timestamp('created_date')->nullable();

            $table->unsignedInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('users');

            $table->string('body_temp')->nullable();
            $table->string('body_weight')->nullable();
            $table->string('body_height')->nullable();
            $table->string('blood_pressure')->nullable();

            $table->text('result')->nullable();
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
        Schema::dropIfExists('exam_results');
    }
}
