<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_preferences', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('preferred_activity_type');

            $table->enum('preferred_duration', [
                '<= 15 menit',
                '10 - 30 menit',
                '> 30 menit'
            ]);

            $table->enum('preferred_intensity', [
                'Ringan',
                'Sedang'
            ]);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};
