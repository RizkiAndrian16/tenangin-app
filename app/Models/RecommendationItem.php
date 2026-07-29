<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecommendationItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'recommendation_id',
        'activity_id',
        'similarity_score',
        'ranking',
        'started_at'
    ];

    protected $casts = [
        'similarity_score' => 'decimal:4',
        'ranking' => 'integer',
        'started_at' => 'datetime',
    ];

    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
