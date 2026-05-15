<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'gender',
        'age',
        'phone_number',
        'profile_photo',
        'university',
        'major',
        'semester',
        'residence_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'age' => 'integer',
        'semester' => 'integer',
    ];

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    public function preferences()
    {
        return $this->hasMany(UserPreference::class);
    }

    public function activePreference()
    {
        return $this->hasOne(UserPreference::class)
            ->where('is_active', true)
            ->latest('created_at');
    }

    public function pssAssessments()
    {
        return $this->hasMany(PssAssessment::class);
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
