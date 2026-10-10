<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id_penjualan)) {
                $latest = self::orderBy('id_penjualan', 'desc')->first();
                if (!$latest) {
                    $model->id_penjualan = 'PJ001';
                } else {
                    $number = intval(substr($latest->id_penjualan, 2)) + 1;
                    $model->id_penjualan = 'PJ' . str_pad($number, 3, '0', STR_PAD_LEFT);
                }
            }
        });
    }

    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_penjualan', 'id_karyawan', 'nama_pembeli_umum', 'tanggal_penjualan', 'total_bayar'];

    public function details() {
        return $this->hasMany(PenjualanDetail::class, 'id_penjualan', 'id_penjualan');
    }

    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}
