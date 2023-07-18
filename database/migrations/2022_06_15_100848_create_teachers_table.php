<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('teachers', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->foreignId('user_id');
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->enum('gender', ['male', 'female']);
            $table->string('birth_date');
            $table->string('phone');
            $table->string('image');
            $table->string('province');
            $table->string('city');
            $table->string('nationality');
            $table->string('about')->nullable();
            $table->string('postal_code');
            $table->double('lat')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->double('lng')->nullable();
            $table->double('range')->nullable();
            $table->boolean('has_car')->default(0);
            $table->boolean('has_license')->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('generate_password')->default(0);
            $table->boolean('change_password')->default(0);
            $table->boolean('send_email')->default(0);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('teachers');
    }
};
