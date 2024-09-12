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
        Schema::create('office_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('roomName');
            $table->string('temp')->nullable();
            $table->string('humidity')->nullable();
            $table->string('noise')->nullable();
            $table->string('light')->nullable();
            $table->unsignedBigInteger('brightness')->nullable();
            $table->string('mode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_rooms');
    }
};
