<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function patients()
    {
        return $this->belongsToMany(Patient::class);
    }
}
