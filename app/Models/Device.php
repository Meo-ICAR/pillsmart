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

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function getSlotsByMac($mac)
    {
        $device = $this->where('mac', $mac)->first();

        if (!$device) {
            return null;
        }

        return $device->slots()
            ->select('n', 'operhour')
            ->get()
            ->map(function ($slot) {
                return [
                    'n' => $slot->n,
                    'opentime' => $slot->operhour ? date('Y-m-d H:i', strtotime($slot->operhour)) : null
                ];
            });
    }
}
