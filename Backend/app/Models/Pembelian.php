<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id_pembelian)) {
                $latest = self::orderBy('id_pembelian', 'desc')->first();
                if (!$latest) {
                    $model->id_pembelian = 'PB001';
                } else {
                    $number = intval(substr($latest->id_pembelian, 2)) + 1;
                    $model->id_pembelian = 'PB' . str_pad($number, 3, '0', STR_PAD_LEFT);
                }
            }
        });
    }

    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_pembelian', 'id_distributor', 'id_karyawan', 'tanggal_beli', 'total_bayar'];

    public function details() {
        return $this->hasMany(PembelianDetail::class, 'id_pembelian', 'id_pembelian');
    }

    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    public function distributor() {
        return $this->belongsTo(Distributor::class, 'id_distributor', 'id_distributor');
    }
}
