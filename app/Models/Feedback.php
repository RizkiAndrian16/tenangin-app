<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'recommendation_item_id',
        'is_completed',
        'is_helpful',
        'calmness_score',
        'comfort_score',
        'stress_reduction_score',
        'willingness_score',
        'notes',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'is_helpful' => 'boolean',
        'calmness_score' => 'integer',
        'comfort_score' => 'integer',
        'stress_reduction_score' => 'integer',
        'willingness_score' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recommendationItem()
    {
        return $this->belongsTo(RecommendationItem::class);
    }
}
