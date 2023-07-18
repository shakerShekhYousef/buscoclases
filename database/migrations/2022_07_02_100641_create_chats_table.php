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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->nullable();
            $table->foreignId('customer_id')->nullable();
            $table->enum('status', ['open', 'closed']);
            $table->foreignId('admin')->nullable();
            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers');
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers');
            $table->foreign('admin')
                ->references('id')
                ->on('users');
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
        Schema::dropIfExists('chats');
    }
};
