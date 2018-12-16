<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlternativeComparisonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alternative_comparisons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('criteria_id');
            $table->unsignedInteger('x_alternative_id');
            $table->unsignedInteger('y_alternative_id');
            $table->float('value', 8, 5);
            $table->timestamps();

            $table->foreign('criteria_id')->references('id')->on('criterias')->onDelete('cascade');
            $table->foreign('x_alternative_id')->references('id')->on('alternatives')->onDelete('cascade');
            $table->foreign('y_alternative_id')->references('id')->on('alternatives')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alternative_comparisons');
    }
}
