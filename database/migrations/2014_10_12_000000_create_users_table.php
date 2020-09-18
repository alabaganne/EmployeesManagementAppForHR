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
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('address')->nullable();
            $table->enum('civil_status', ['single', 'married'])->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('id_card_number')->unique()->nullable();
            $table->string('nationality')->nullable();
            $table->string('university')->nullable();
            $table->string('history')->nullable();
            $table->integer('experience_level')->nullable();
            $table->string('source')->nullable();
            $table->string('position')->nullable();
            $table->string('grade')->nullable(); // ?may be "enum" too
            $table->date('hiring_date')->nullable(); // contract_start_date
            $table->date('contract_end_date')->nullable();
            $table->enum('type_of_contract', ['option 1', 'option 2', 'option 3'])->nullable();
            $table->integer('allowed_leave_days')->nullable();
            // !department_id FOREIGN KEY is added on a seperate migration file
            // $table->string('profile_photo');
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
        Schema::dropIfExists('skills'); // !skills table uses the users table that's why it must be deleted first
        Schema::dropIfExists('users');
        Schema::dropIfExists('departments'); // !users table uses the departments table
    }
}
