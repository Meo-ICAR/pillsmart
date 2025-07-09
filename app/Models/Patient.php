<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

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
        'anamnesi',
    ];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }

    public function caregivers()
    {
        return $this->belongsToMany(Caregiver::class)
            ->withPivot('fromdate', 'todate', 'deleted_at')
            ->withTimestamps()
            ->withTrashed();
    }
}
