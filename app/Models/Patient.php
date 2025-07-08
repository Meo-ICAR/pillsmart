<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'date_of_birth',
        'breakfast_hour',
        'lunch_hour',
        'dinner_hour',
        'wakeup_hour',
        'sleep_hour',
        'address',
        'user_id',
    ];
}
