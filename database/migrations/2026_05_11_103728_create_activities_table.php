<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->text('description');

            $table->string('activity_type');

            $table->enum('duration_category', [
                '<= 15 menit',
                '10 - 30 menit',
                '> 30 menit'
            ])->nullable();

            $table->enum('intensity_level', [
                'Ringan',
                'Sedang'
            ])->nullable();

            $table->string('stress_level_target');

            $table->enum('status', [
                'Direkomendasikan',
                'Direkomendasikan terbatas',
                'Tidak direkomendasikan',
                'Perlu perhatian'
            ]);

            $table->text('instruction')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
