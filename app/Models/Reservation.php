<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'branch',
        'pax',
        'reservation_date',
        'reservation_time',
        'note',
        'status'
    ];
}
