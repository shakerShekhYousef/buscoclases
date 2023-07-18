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
        Schema::create('teacher_sub_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_material_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign('sub_material_id')->references('id')->on('sub_materials')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
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
        Schema::dropIfExists('teacher_sub_materials');
    }
};
