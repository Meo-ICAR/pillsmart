<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mac',
        'nslots',
        'annotations',
        'patient_id',
        'istoupdate',
        'updated_at',
        'pinged_at',
    ];
}
