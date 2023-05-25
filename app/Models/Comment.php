<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'user_id',
        'curriculum_id',
        'curriculum_revision_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id');
    }

    public function curriculumRevision()
    {
        return $this->belongsTo(CurriculumRevision::class, 'curriculum_revision_id');
    }
}
