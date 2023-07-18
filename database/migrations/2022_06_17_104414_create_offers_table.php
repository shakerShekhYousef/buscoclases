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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('material_id');
            $table->string('position_title');
            $table->text('description');
            $table->double('lat');
            $table->double('lng');
            $table->double('range');
            $table->enum('job_type', ['part_time', 'full_time']);
            $table->double('working_hours');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('immediate_incorporation')->default(0);
            $table->double('salary');
            $table->double('full_salary');
            $table->string('level');
            $table->boolean('require_experience')->default(0);
            $table->boolean('prepare_official_exam')->default(0);
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
            $table->foreign('material_id')
                ->references('id')
                ->on('materials')
                ->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('offers');
    }
};
