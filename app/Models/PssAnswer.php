<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PssAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'pss_assessment_id',
        'question_number',
        'answer_score',
    ];

    protected $casts = [
        'question_number' => 'integer',
        'answer_score' => 'integer',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(PssAssessment::class);
    }
}
