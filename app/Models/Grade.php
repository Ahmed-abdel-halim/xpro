<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['stage_id', 'name'];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
