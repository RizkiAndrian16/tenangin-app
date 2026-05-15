<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendation_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('recommendation_id')->constrained()->cascadeOnDelete();

            $table->foreignId('activity_id')->constrained()->cascadeOnDelete();

            $table->decimal('similarity_score', 5, 4)->nullable();

            $table->integer('ranking')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendation_items');
    }
};
