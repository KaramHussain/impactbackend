<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClaimRemarkCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_remark_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('claim_id')->index();
            $table->string('code')->nullable();
            $table->boolean('avoidable')->default(0);
            $table->boolean('low_fruit')->default(0);
            $table->boolean('compliance')->default(0);
            $table->foreign('claim_id')->references('id')->on('provider_claims');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_remark_codes');
    }
}
