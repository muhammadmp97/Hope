<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->enum('status', ['ongoing', 'surrendered', 'abandoned', 'completed'])->default('ongoing');
            $table->string('text')->nullable();
            $table->timestamp('continued_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenges');
    }
};
