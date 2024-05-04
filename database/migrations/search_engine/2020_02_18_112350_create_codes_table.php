<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->index();
            $table->integer('frequency')->default(0);
            $table->string('gender', 1)->nullable();
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->unsignedBigInteger('children_term_id')->index();
            $table->unsignedInteger('category_id')->index();
            $table->unsignedInteger('sub_category_id')->index();

            $table->unique(['code', 'category_id', 'sub_category_id', 'children_term_id'], 'unique_rows');

            $table->foreign('children_term_id')->references('id')->on('children_terms');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codes');
    }
}
