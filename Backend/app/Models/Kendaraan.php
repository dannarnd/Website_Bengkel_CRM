<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';

    // Konfigurasi Primary Key Custom
    protected $primaryKey = 'nomor_polisi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    // Relasi ke Pelanggan (Pemilik)
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Relasi ke Service
    public function services()
    {
        return $this->hasMany(Service::class, 'nomor_polisi', 'nomor_polisi');
    }
}
