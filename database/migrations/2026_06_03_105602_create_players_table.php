<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->tinyInteger('difficulty')->default(3);   // 3, 4, or 5
            $table->enum('result', ['win', 'timeout'])->nullable();
            $table->unsignedInteger('moves')->nullable();
            $table->unsignedInteger('time_taken')->nullable(); // seconds elapsed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
