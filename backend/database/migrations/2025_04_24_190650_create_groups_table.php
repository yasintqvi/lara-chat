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
        Schema::create('groups', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('title');
            $table->string('avatar')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('group_user', function (Blueprint $table) {
            $table->foreignUlid('group_id')->constrained('groups');
            $table->foreignUlid('user_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
