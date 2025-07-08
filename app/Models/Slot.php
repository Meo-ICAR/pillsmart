<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $fillable = [
        'device_id',
        'n',
        'operhour',
        'npill',
        'name',
        'description',
    ];
}
