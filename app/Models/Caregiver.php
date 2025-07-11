<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caregiver extends Model
{
    protected $fillable = [
        'name',
        'kind',
        'user_id',
    ];

    public function patients()
    {
        return $this->belongsToMany(Patient::class)
            ->withPivot('fromdate', 'todate', 'deleted_at')
            ->withTimestamps()
            ->withTrashed();
    }
}
