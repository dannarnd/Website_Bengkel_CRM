<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    protected $table = 'service_detail';
    protected $primaryKey = 'id_service_detail';

    protected $fillable = ['id_service', 'kode_barang', 'qty', 'subtotal'];

    public function sparepart() {
        return $this->belongsTo(Sparepart::class, 'kode_barang', 'kode_barang');
    }
}
