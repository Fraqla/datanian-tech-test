<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $fillable = ['station_id', 'type', 'capability', 'status'];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
