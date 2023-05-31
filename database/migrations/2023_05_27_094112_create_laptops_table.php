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

            $table->string('manufacturer')->nullable();
            $table->string('size')->nullable();
            $table->string('resolution')->nullable();
            $table->string('screenType')->nullable();
            $table->string('touch')->nullable();
            $table->string('processorName')->nullable();
            $table->string('physicalCores')->nullable();
            $table->string( 'clockSpeed')->nullable();
            $table->string('ram')->nullable();
            $table->string('storage')->nullable();
            $table->string('discType')->nullable();
            $table->string('graphicCardName')->nullable();
            $table->string('memory')->nullable();
            $table->string('os')->nullable();
            $table->string('disc_reader')->nullable();
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
