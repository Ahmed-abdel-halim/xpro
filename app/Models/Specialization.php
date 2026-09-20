<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * الأساتذة المنتمين لهذا الاختصاص
     */
    public function teachers()
    {
        return $this->hasMany(User::class, 'specialization', 'name')->where('role', 'teacher');
    }
}
