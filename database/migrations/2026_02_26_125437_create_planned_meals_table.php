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
        Schema::create('planned_meals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();

            $table->date('date');

            $table->string('meal_type')->default('souper');

            $table->integer('portions');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planned_meals');
    }
};
