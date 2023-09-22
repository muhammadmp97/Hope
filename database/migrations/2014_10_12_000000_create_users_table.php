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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nick_name');
            $table->string('bio')->nullable();
            $table->string('avatar_url')->nullable();
            $table->foreignId('country_id')->index('country_id_index')->constrained();
            $table->unsignedTinyInteger('addiction_type')->index('addiction_type_index');
            $table->boolean('is_recovered')->default(false);
            $table->unsignedInteger('score')->default(0);
            $table->date('birth_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
