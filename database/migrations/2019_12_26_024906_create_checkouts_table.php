<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('doctor_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('cpt')->index();
            $table->timestamp('date_of_appointment');
            $table->time('time_of_appointment');
            $table->dateTime('date_of_booking');
            $table->decimal('average_cost');
            $table->decimal('purchase_cost');
            $table->decimal('saved_cost');
            $table->decimal('negotiated_cost')->nullable();
            $table->decimal('anesthesia_fee');
            $table->decimal('facility_expenses');
            $table->decimal('hidden_charges')->nullable();
            $table->decimal('evob_charges')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

            $table->foreign('order_id')->references('id')->on('orders')
            ->onDelete('cascade');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkouts');
    }
}
