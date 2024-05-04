<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('claim_id')->unique();
            $table->unsignedBigInteger('order_id')->unique();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('provider_id')->index();//doctor
            $table->unsignedBigInteger('patient_insurance_id')->index()->nullable();//insurance
            $table->date('date_of_service');
            $table->string('claim_status');
            $table->time('claim_time');
            $table->date('transaction_date');
            $table->time('transaction_time');
            $table->date('interchange_date');
            $table->time('interchange_time');
            $table->string('submitter_entity_identifier_code', 10);
            $table->string('submitter_name');
            $table->string('submitter_contact_name');
            $table->string('submitter_communication_number');
            $table->string('receiver_entity_identifier_code');
            $table->string('receiver_name');
            $table->string('receiver_identification_code');
            $table->float('total_claim_charge_amount');
            $table->integer('no_of_proc');
            $table->integer('no_of_dx');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('patient_insurance_id')->references('id')->on('patient_insurances');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claims');
    }
}
