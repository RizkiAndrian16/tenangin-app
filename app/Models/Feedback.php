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
        'activity_completed',
        'benefit_rating',
        'calmness_before',
        'calmness_after',
        'notes',
    ];

    protected $casts = [
        'activity_completed' => 'boolean',
        'benefit_rating' => 'integer',
        'calmness_before' => 'integer',
        'calmness_after' => 'integer',
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
