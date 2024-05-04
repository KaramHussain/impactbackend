<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('practise_id')->index();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('email_token')->nullable();
            $table->string('npi')->nullable();
            $table->boolean('is_doctor')->default(0);
            $table->boolean('active')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('practise_id')->references('id')->on('practises');
            $table->foreign('created_by')->references('id')->on('providers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
