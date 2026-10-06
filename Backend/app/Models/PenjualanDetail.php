<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    protected $table = 'penjualan_detail';
    protected $primaryKey = 'id_penj_detail';

    protected $fillable = ['id_penjualan', 'kode_barang', 'qty', 'harga_jual', 'subtotal'];

    public function sparepart() {
        return $this->belongsTo(Sparepart::class, 'kode_barang', 'kode_barang');
    }
}
