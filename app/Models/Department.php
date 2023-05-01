<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_code',
        'description',
        'chairs',
        'members',
    ];

    public function members()
    {
        return $this->hasMany(User::class);
    }
    
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function curriculums()
    {
        return $this->hasMany(Curriculum::class);
    }
}
