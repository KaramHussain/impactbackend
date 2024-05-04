<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_insurances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('insurance_person', 20);
            $table->string('insurance_package', 20);
            $table->string('financial_guarantor_name')->nullable();
            $table->string('insured_ssn', 11);
            $table->string('insurance_name');
            $table->string('insurance_type');
            $table->integer('insurance_policy_number');
            $table->string('insurance_service_number');
            $table->string('insurance_plan_name');
            $table->tinyInteger('is_employeed')->default(0);
            $table->tinyInteger('can_contact_employer')->default(0);
            $table->string('name_of_employer')->nullable();
            $table->string('hr_contact_person')->nullable();
            $table->string('hr_phone_no', 10)->nullable();
            $table->integer('group_id_no')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_insurance');
    }
}
