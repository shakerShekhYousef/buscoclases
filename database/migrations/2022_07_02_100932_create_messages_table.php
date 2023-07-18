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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id');
            $table->unsignedBigInteger('sender_id');
            $table->text('message');
            $table->string('message_type')->default('text');
            $table->foreign('chat_id')
                ->references('id')
                ->on('chats')
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
        Schema::dropIfExists('messages');
    }
};
