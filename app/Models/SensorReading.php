<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    protected $fillable = ['ph_level', 'turbidity', 'tds', 'status', 'water_level'];
}
