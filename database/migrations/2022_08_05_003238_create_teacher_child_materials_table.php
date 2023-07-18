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
        Schema::create('teacher_child_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('child_material_id');
            $table->unsignedBigInteger('teacher_id');
            $table->foreign('child_material_id')->references('id')->on('child_materials')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
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
        Schema::dropIfExists('teacher_child_materials');
    }
};
