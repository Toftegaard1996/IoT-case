<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeRooms extends Model
{
    use HasFactory;

    protected $fillable = [
        'roomName',
        'temp',
        'humidity',
        'noise',
        'light',
        'motion',
    ];
}
