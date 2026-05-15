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
    ];

    protected $casts = [
        'similarity_score' => 'decimal:4',
        'ranking' => 'integer',
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
