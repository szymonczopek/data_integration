<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('manufacturer');
            $table->string('size');
            $table->string('resolution');
            $table->string('screenType');
            $table->string('touch');
            $table->string('processorName');
            $table->integer('physicalCores');
            $table->integer( 'clockSpeed');
            $table->string('ram');
            $table->string('storage');
            $table->string('discType');
            $table->string('graphicCardName');
            $table->string('memory');
            $table->string('os');
            $table->string('disc_reader');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
