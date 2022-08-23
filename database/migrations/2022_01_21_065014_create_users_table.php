<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('country_code')->nullable();
            $table->string('mobile');
            $table->string('cover')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->default('other');
            $table->tinyInteger('verified')->nullable();
            $table->enum('type', ['user', 'admin', 'driver', 'store'])->default('user'); // 0 = admin // 1 = user // 2 = store // 3 driver
            $table->date('dob')->nullable();
            $table->date('date')->nullable();
            $table->text('fcm_token')->nullable();
            $table->text('others')->nullable();
            $table->text('stripe_key')->nullable();
            $table->text('extra_field')->nullable();
            $table->tinyInteger('status')->default(1);
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
