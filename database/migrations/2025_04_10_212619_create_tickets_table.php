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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['ouvert', 'en_cours', 'resolu', 'ferme'])->default('ouvert');
            $table->string('category')->nullable();
            $table->enum('priority', ['basse', 'moyenne', 'haute'])->nullable();
            $table->date('due_date')->nullable();
            
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('agent_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
