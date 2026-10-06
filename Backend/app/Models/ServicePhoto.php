<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePhoto extends Model
{
    protected $table = 'service_photo';
    
    protected $guarded = ['id'];

    // Foto ini mendokumentasikan nota servis yang mana
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
