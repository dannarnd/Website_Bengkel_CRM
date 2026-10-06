<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id_pelanggan)) {
                $latest = self::orderBy('id_pelanggan', 'desc')->first();
                if (!$latest) {
                    $model->id_pelanggan = 'P001';
                } else {
                    $number = intval(substr($latest->id_pelanggan, 1)) + 1;
                    $model->id_pelanggan = 'P' . str_pad($number, 3, '0', STR_PAD_LEFT);
                }
            }
        });
    }

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_pelanggan', 'nama_pelanggan', 'nomor_hp'];

    public function kendaraans() {
        return $this->hasMany(Kendaraan::class, 'id_pelanggan', 'id_pelanggan');
    }
}
