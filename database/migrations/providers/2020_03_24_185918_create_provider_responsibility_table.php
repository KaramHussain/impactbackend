<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderResponsibilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_responsibility', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('provider_id')->index();
            $table->morphs('responsable');
            $table->foreign('provider_id')->references('id')->on('providers');

            $table->unique(['responsable_id', 'responsable_type', 'provider_id'], 'unique_cols');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_responsibility');
    }
}
