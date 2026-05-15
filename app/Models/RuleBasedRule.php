<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RuleBasedRule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'stress_level',
        'activity_id',
        'description',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
