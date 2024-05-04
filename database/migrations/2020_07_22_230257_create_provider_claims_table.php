<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_claims', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('claim_id')->index();
            $table->enum('status', ['to_be_reviewed', 'assigned', 'submitted', 'resolved'])->default('to_be_reviewed')->index();
            $table->enum('claim_status', ['denied', 'accepted', 'rejected'])->default('denied')->index();
            $table->unsignedBigInteger('practise_id')->index();
            $table->unsignedBigInteger('provider_id')->index()->nullable();
            $table->unsignedBigInteger('payer_id')->index()->nullable();
            $table->string('patient_name')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('payer_name')->nullable();
            $table->double('total_claim_charges');
            $table->double('patient_responsibility');
            $table->double('total_paid_amount');
            $table->timestamp('date_of_service');
            $table->timestamp('date_of_assigned')->nullable();
            $table->timestamp('date_of_submission')->nullable();
            $table->integer('days_to_submit')->default(0);
            $table->integer('days_to_resolve')->default(0);
            $table->timestamp('date_resolved')->nullable();
            $table->timestamps();


            //$table->foreign('practise_id')->references('id')->on('practises');
            //$table->foreign('provider_id')->references('id')->on('providers');

            //we will not save provider_id or responsible_id on start becasue we will only just save
            //all claims and will show when collector is on dashboard all claims based on his
            // remark code type and payer_id
            // wheen some collector say I will work on some claim id responsible id
            // will be saved on that claim and locked will be 1


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_claims');
    }
}