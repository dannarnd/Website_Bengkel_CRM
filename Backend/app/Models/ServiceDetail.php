<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    protected $table = 'service_detail';
    
    protected $guarded = ['id'];

    // Rincian ini milik nota servis yang mana
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Rincian ini memakai sparepart apa
    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }
}
