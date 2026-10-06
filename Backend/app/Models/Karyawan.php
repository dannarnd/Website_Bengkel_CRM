<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Karyawan extends Authenticatable
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id_karyawan)) {
                $latest = self::orderBy('id_karyawan', 'desc')->first();
                if (!$latest) {
                    $model->id_karyawan = 'KAR001';
                } else {
                    $number = intval(substr($latest->id_karyawan, 3)) + 1;
                    $model->id_karyawan = 'KAR' . str_pad($number, 3, '0', STR_PAD_LEFT);
                }
            }
        });
    }

    use HasApiTokens, Notifiable;
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_karyawan', 'name', 'username', 'email', 'password', 'jabatan'];
    protected $hidden = ['password', 'remember_token'];
}
