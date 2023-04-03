<?php

namespace App\Models;

use App\Notifications\ResetPasswordCodeNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function curriculums()
    {
        return $this->hasMany(Curriculum::class);
    }

    public function revisionCurriculums()
    {
        return $this->hasMany(CurriculumRevision::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'username',
        'role',
        'status',
        'department_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordCodeNotification($token));
    }

    private function createSixDigitCode($token)
    {
        $code = substr(str_replace('/', '', bcrypt($token)), 0, 6); // Generate a 6-digit code from the token
        return $code;
    }
}
