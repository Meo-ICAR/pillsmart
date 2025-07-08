<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'name',
        'mac',
        'nslots',
        'annotations',
        'patient_id',
        'istoupdate',
        'updated_at',
    ];
}
