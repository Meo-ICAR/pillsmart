<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use SoftDeletes;
    use HasFactory;

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
