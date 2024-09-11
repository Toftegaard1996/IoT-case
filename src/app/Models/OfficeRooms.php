<?php
// app/Models/OfficeRoom.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeRooms extends Model
{
    use HasFactory;

    // Define the table name if it's different from the model name (in plural form)
    protected $table = 'office_rooms';  // Adjust if necessary

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'roomName',
        'temp',
        'humidity',
        'noise',
        'light',
        'brightness',
        'mode',
    ];
}
