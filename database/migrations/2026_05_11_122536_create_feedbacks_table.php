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

            $table->boolean('is_completed')->default(false);

            $table->boolean('is_helpful')->nullable();

            $table->integer('calmness_score')->nullable();         // Seberapa tenang?

            $table->integer('comfort_score')->nullable();          // Seberapa nyaman?

            $table->integer('stress_reduction_score')->nullable(); // Membantu mengurangi stres?

            $table->integer('willingness_score')->nullable();      // Bersedia mengulang? (Untuk penalti/reward)

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
