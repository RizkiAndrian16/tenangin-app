<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pss_answers', function (Blueprint $table) {

            $table->id();

            $table->foreignId('pss_assessment_id')->constrained()->cascadeOnDelete();

            $table->integer('question_number');

            $table->integer('answer_score');

            $table->timestamps();

            $table->unique([
                'pss_assessment_id',
                'question_number'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pss_answers');
    }
};
