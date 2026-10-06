<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    protected $table = 'sparepart';
    
    protected $guarded = ['id'];

    // Relasi ke ServiceDetail: Satu jenis sparepart bisa tercatat di banyak rincian servis
    public function serviceDetails()
    {
        return $this->hasMany(ServiceDetail::class);
    }

    // Relasi ke StockAdjustment: Satu sparepart memiliki banyak riwayat keluar/masuk
    public function stockAdjustments()
    {
        return $this->hasMany(StockAdjustment::class);
    }
}
