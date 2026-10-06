<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id_service)) {
                $latest = self::orderBy('id_service', 'desc')->first();
                if (!$latest) {
                    $model->id_service = 'S001';
                } else {
                    $number = intval(substr($latest->id_service, 1)) + 1;
                    $model->id_service = 'S' . str_pad($number, 3, '0', STR_PAD_LEFT);
                }
            }
        });
    }

    protected $table = 'service';
    protected $primaryKey = 'id_service';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_service', 'id_kendaraan', 'id_karyawan', 'invoice_number', 'status', 'total_biaya', 'catatan'];

    public function kendaraan() {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan', 'id_kendaraan');
    }
    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
    public function details() {
        return $this->hasMany(ServiceDetail::class, 'id_service', 'id_service');
    }
    public function photos() {
        return $this->hasMany(ServicePhoto::class, 'id_service', 'id_service');
    }
    public function warranty() {
        return $this->hasOne(Warranty::class, 'id_service', 'id_service');
    }
}
