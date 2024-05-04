<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePractisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('phone');
            $table->string('zipcode', 5);
            $table->unsignedBigInteger('city')->index();
            $table->unsignedBigInteger('state')->index();
            $table->string('admin_email')->unique();
            $table->text('address');
            $table->timestamps();

            $table->foreign('city')->references('id')->on('cities');
            $table->foreign('state')->references('id')->on('states');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('practise');
    }
}
