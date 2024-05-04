<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('gender');
            $table->string('credentials', 10)->nullable();
            $table->timestamp('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('alt_phone')->nullable();
            $table->string('alt_email')->unique()->nullable();
            $table->unsignedBigInteger('language')->nullable();
            $table->tinyInteger('has_insurance')->default(0);
            $table->string('security_question1')->nullable();
            $table->string('security_question2')->nullable();
            $table->string('security_answer1')->nullable();
            $table->string('security_answer2')->nullable();
            $table->string('user_image')->nullable();
            $table->string('activation_token')->nullable();
            $table->tinyInteger('active')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
