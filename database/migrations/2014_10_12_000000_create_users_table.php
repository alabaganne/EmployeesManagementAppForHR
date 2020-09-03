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
            $table->id();
            $table->string('name');
            $table->string('email')->unique(); // ? unique
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('birth_date')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('school')->nullable();
            $table->string('history')->nullable();
            $table->string('position')->nullable();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->integer('allowed_leaves')->nullable();
            $table->string('ncin')->unique()->nullable(); // ? unique
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
        Schema::dropIfExists('departments'); // ! users table uses the departments table so it has to be deleted first
    }
}
