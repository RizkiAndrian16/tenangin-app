<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->foreignId('recommendation_item_id')->constrained()->cascadeOnDelete();

            $table->boolean('activity_completed')->default(false);

            $table->integer('benefit_rating')->nullable();

            $table->integer('calmness_before')->nullable();

            $table->integer('calmness_after')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
