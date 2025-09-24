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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // owner of the task
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // task fields
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'done'])->default('pending');

            // created_at / updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
