<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemarkCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remark_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('remark_code')->unique();
            $table->string('remark_description');
            $table->string('low_fruit')->default(0);
            $table->string('compliance')->default(0);
            $table->string('avoidable')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('remark_codes');
    }
}
