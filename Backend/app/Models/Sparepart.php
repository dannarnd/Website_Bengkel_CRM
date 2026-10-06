<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    protected $table = 'sparepart';
    protected $primaryKey = 'kode_barang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kode_barang', 'nama_barang', 'harga', 'stok', 'batas_minimum'];
}
