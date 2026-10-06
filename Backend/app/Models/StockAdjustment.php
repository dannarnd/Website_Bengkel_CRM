<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    protected $table = 'stock_adjustment';
    
    protected $guarded = ['id'];

    // Riwayat ini menjelaskan pergerakan stok sparepart apa
    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }

    // Siapa yang mencatat mutasi stok ini
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
