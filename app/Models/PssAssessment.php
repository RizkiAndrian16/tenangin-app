<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PssAssessment extends Model
{
    use HasFactory, SoftDeletes;

    public const QUESTIONS = [
        1 => 'Seberapa sering kamu merasa kecewa karena sesuatu yang terjadi secara tidak terduga?',
        2 => 'Seberapa sering kamu merasa tidak mampu mengendalikan hal-hal penting dalam hidupmu?',
        3 => 'Seberapa sering kamu merasa gelisah dan stres?',
        4 => 'Seberapa sering kamu merasa percaya diri dengan kemampuanmu untuk menyelesaikan masalah pribadi?',
        5 => 'Seberapa sering kamu merasa segala sesuatu berjalan sesuai keinginanmu?',
        6 => 'Seberapa sering kamu mengetahui bahwa kamu tidak bisa mengatasi hal-hal yang harus kamu lakukan?',
        7 => 'Seberapa sering kamu mampu mengendalikan hal-hal yang menjengkelkan dalam hidupmu?',
        8 => 'Seberapa sering kamu merasa mampu mengendalikan permasalahanmu?',
        9 => 'Seberapa sering kamu marah karena hal-hal yang terjadi di luar kendalimu?',
        10 => 'Seberapa sering kamu merasa tidak mampu menyelesaikan permasalahan-permasalahan yang menumpuk dalam hidupmu?',
    ];

    public const OPTIONS = [
        0 => 'Tidak Pernah',
        1 => 'Hampir Tidak Pernah',
        2 => 'Kadang-kadang',
        3 => 'Cukup Sering',
        4 => 'Sangat Sering',
    ];

    protected $fillable = [
        'user_id',
        'total_score',
        'stress_level',
    ];

    protected $casts = [
        'total_score' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(PssAnswer::class);
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class);
    }
}
