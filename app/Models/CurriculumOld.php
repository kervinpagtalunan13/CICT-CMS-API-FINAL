<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumOld extends Model
{
    use HasFactory;

    protected $fillable = [
        'version',
        'metadata',
        'curriculum_id',
        'increment_version'
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
