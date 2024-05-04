<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodeChildrenTermTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_term', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('code_id')->index();
            $table->unsignedBigInteger('term_id')->index();

            $table->unique(['term_id', 'code_id']);

            $table->foreign('code_id')->references('id')->on('codes');
            $table->foreign('term_id')->references('id')->on('terms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('code_children_term');
    }
}
