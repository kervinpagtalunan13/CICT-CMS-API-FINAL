<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'user_id',
        'department_id',
        'version',
        'status',
        'metadata',
        'approve_by'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function oldCurriculums()
    {
        return $this->hasMany(CurriculumOld::class);
    }

    public function revisionCurriculums()
    {
        return $this->hasMany(CurriculumOld::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approve_by');
    }

    public function comments()
    {
        $this->hasMany(Curriculum::class);
    }
}
