<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'service';
    
    protected $guarded = ['id'];

    // Nota Service ini milik siapa (Relasi N:1 ke Pelanggan)
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'nomor_polisi', 'nomor_polisi');
    }

    // Nota Service ini dikerjakan oleh siapa (Relasi N:1 ke User/Mekanik)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Nota Service ini menghabiskan barang apa saja (Relasi 1:N ke ServiceDetail)
    public function serviceDetails()
    {
        return $this->hasMany(ServiceDetail::class);
    }

    // Nota Service ini punya foto bukti apa saja (Relasi 1:1 ke ServicePhoto)
    public function servicePhoto()
    {
        return $this->hasOne(ServicePhoto::class);
    }

    // Nota Service ini punya garansi apa (Relasi 1:1 ke Warranty)
    public function warranty()
    {
        return $this->hasOne(Warranty::class);
    }
}
