<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriteriaComparisonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criteria_comparisons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('first_criteria_id');
            $table->float('value');
            $table->unsignedInteger('second_criteria_id');
            $table->timestamps();

            $table->foreign('first_criteria_id')->references('id')->on('criterias')->onDelete('cascade');
            $table->foreign('second_criteria_id')->references('id')->on('criterias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('criteria_comparisons');
    }
}
