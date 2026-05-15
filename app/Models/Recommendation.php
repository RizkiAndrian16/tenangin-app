<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recommendation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'pss_assessment_id',
        'user_preference_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pssAssessment()
    {
        return $this->belongsTo(PssAssessment::class);
    }

    public function userPreference()
    {
        return $this->belongsTo(UserPreference::class);
    }

    public function recommendationItems()
    {
        return $this->hasMany(RecommendationItem::class);
    }
}
