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
        Schema::create('teacher_available_times', function (Blueprint $table) {
            $table->id();
            $table->time('time');
            $table->string('details')->nullable();
            $table->boolean('is_available')->default(1);
            $table->foreignId('schedule_id');
            $table->foreign('schedule_id')
                ->references('id')
                ->on('teacher_schedules')
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
        Schema::dropIfExists('teacher_available_times');
    }
};
