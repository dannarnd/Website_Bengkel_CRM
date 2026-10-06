<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id_kendaraan)) {
                $latest = self::orderBy('id_kendaraan', 'desc')->first();
                if (!$latest) {
                    $model->id_kendaraan = 'K001';
                } else {
                    $number = intval(substr($latest->id_kendaraan, 1)) + 1;
                    $model->id_kendaraan = 'K' . str_pad($number, 3, '0', STR_PAD_LEFT);
                }
            }
        });
    }

    protected $table = 'kendaraan';
    protected $primaryKey = 'id_kendaraan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_kendaraan', 'id_pelanggan', 'nomor_polisi', 'merk_mobil'];

    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
}
