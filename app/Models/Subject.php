<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['grade_id', 'name', 'image'];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
