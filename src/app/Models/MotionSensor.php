<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotionSensor extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'motion_sensors';

    // Specify the fillable fields
    protected $fillable = [
        'motion_detected',
        'created_at',
    ];

    // Disable the default timestamps (created_at and updated_at)
    public $timestamps = false;
}