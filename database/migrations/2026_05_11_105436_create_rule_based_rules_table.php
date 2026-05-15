<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rule_based_rules', function (Blueprint $table) {

            $table->id();

            $table->enum('stress_level', [
                'Rendah',
                'Sedang',
                'Tinggi'
            ]);

            $table->foreignId('activity_id')->constrained()->cascadeOnDelete();

            $table->text('description')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rule_based_rules');
    }
};
