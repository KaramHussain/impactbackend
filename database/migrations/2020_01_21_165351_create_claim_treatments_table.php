<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClaimTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_treatments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('claim_id');
            $table->string('cpt_code');
            $table->string('cpt_status'); //[open, closed]
            $table->string('cpt_description')->nullable();
            $table->string('mod1')->nullable();
            $table->string('mod2')->nullable();
            $table->string('mod3')->nullable();
            $table->string('mod4')->nullable();
            $table->string('dx1')->nullable();
            $table->string('dx2')->nullable();
            $table->string('dx3')->nullable();
            $table->string('dx4')->nullable();
            $table->integer('pos');
            $table->integer('tos');
            $table->integer('cpt_units');
            $table->float('cpt_charged_amount');
            $table->float('cpt_allowed_amount');
            $table->float('cpt_expected_amount')->nullable();
            $table->integer('total_cpts');
            $table->timestamps();


            $table->foreign('claim_id')->references('id')
            ->on('claims')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_treatments');
    }
}
