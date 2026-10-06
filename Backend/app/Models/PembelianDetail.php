<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    protected $table = 'pembelian_detail';
    protected $primaryKey = 'id_pembelian_detail';

    protected $fillable = ['id_pembelian', 'kode_barang', 'qty_masuk', 'harga_beli', 'subtotal'];

    public function sparepart() {
        return $this->belongsTo(Sparepart::class, 'kode_barang', 'kode_barang');
    }
}
