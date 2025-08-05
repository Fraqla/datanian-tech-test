<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = ['name', 'location', 'status'];

    public function sensors()
    {
        return $this->hasMany(Sensor::class);
    }
}
