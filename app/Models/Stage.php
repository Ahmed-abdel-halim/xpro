<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = ['name', 'description', 'image'];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
