<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    
    protected $guarded = ['id'];

    // Relasi ke Kendaraan: Satu pelanggan bisa memiliki banyak kendaraan
    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class);
    }
}
