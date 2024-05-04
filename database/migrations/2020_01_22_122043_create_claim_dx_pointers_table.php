<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClaimDxPointersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_dx_pointers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('claim_id')->index();
            $table->unsignedBigInteger('treatment_id')->index();
            //$table->string('cpt')->index();
            $table->string('dx1')->nullable();
            $table->string('dx2')->nullable();
            $table->string('dx3')->nullable();
            $table->string('dx4')->nullable();
            $table->string('dx5')->nullable();
            $table->string('dx6')->nullable();
            $table->string('dx7')->nullable();
            $table->string('dx8')->nullable();
            $table->string('dx9')->nullable();
            $table->string('dx10')->nullable();
            $table->string('dx11')->nullable();
            $table->string('dx12')->nullable();

            $table->timestamps();

            $table->foreign('claim_id')->references('id')
            ->on('claims')->onDelete('cascade');

            $table->foreign('treatment_id')->references('id')
            ->on('claim_treatments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_dx_pointers');
    }
}
