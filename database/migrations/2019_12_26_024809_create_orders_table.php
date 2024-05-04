<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id')->unique();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('insurance')->index()->nullable();
            $table->timestamp('date_of_service');
            $table->string('order_status');
            $table->dateTime('created_at');

            $table->foreign('user_id')->references('id')->on('users');

            $table->foreign('insurance')->references('id')->on('patient_insurances');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
