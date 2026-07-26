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
        'google_id',
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

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }

        return null;
    }

    public function preferences()
    {
        return $this->hasMany(UserPreference::class);
    }

    // public function activePreference()
    // {
    //     return $this->hasOne(UserPreference::class)
    //         ->where('is_active', true);
    // }

    public function activePreference()
    {
        // Mengambil preferensi paling terakhir dibuat yang belum dihapus (SoftDeletes)
        return $this->hasOne(UserPreference::class)->latest('id');
    }

    public function pssAssessments()
    {
        return $this->hasMany(PssAssessment::class);
    }

    public function latestPssAssessment()
    {
        return $this->hasOne(PssAssessment::class)->latestOfMany();
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function hasCompleteProfile(): bool
    {
        if (!$this->isMahasiswa()) {
            return true;
        }

        return filled($this->name)
            && filled($this->email)
            && filled($this->gender)
            && !is_null($this->age)
            && filled($this->university)
            && filled($this->major)
            && !is_null($this->semester)
            && filled($this->residence_status);
    }

    public function needsPasswordSetup(): bool
    {
        return $this->isMahasiswa()
            && filled($this->google_id)
            && is_null($this->password);
    }
}
