<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'activity_type',
        'duration_category',
        'intensity_level',
        'stress_level_target',
        'status',
        'instruction',
    ];

    public function ruleBasedRules()
    {
        return $this->hasMany(RuleBasedRule::class);
    }

    public function recommendationItems()
    {
        return $this->hasMany(RecommendationItem::class);
    }
}
