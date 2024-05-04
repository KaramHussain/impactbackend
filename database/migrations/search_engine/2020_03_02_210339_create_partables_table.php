<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partables', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('part_id')->index();
            $table->morphs('partable');

            $table->unique(['part_id', 'partable_id', 'partable_type']);

            $table->foreign('part_id')->references('id')->on('parts');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partables');
    }
}
