<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'medicine',
        'dosage',
        'frequency',
        'date_prescribed',
        'instructions',
    ];
}
