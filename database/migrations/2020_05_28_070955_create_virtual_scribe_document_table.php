<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVirtualScribeDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_scribe_document', function (Blueprint $table) {
            $table->increments('id');
            $table->string('part');
            $table->boolean('is_bilateral')->default(0);
            $table->string('bilateral_location')->nullable();
            $table->enum('nature_of_pain', ['constant', 'acute', 'chronic', 'improved', 'worsening']);
            $table->integer('pain_severity');
            $table->date('from');
            $table->boolean('is_present')->default(1);
            $table->date('to')->nullable();
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
        Schema::dropIfExists('virtual_scribe_document');
    }
}
