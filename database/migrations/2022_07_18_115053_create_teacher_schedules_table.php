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
        Schema::create('teacher_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->date('date');
            $table->foreignId('teacher_id');
            $table->foreignId('offer_id')->nullable();
            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->onDelete('cascade');
            $table->foreign('offer_id')
                ->references('id')
                ->on('offers')
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
        Schema::dropIfExists('teacher_schedules');
    }
};
