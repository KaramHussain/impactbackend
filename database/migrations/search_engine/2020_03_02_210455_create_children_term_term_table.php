<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildrenTermTermTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children_term_term', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('children_term_id')->index();
            $table->unsignedBigInteger('term_id')->index();

            $table->unique(['children_term_id', 'term_id']);

            $table->foreign('children_term_id')->references('id')->on('children_terms');
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
        Schema::dropIfExists('children_term_term');
    }
}
