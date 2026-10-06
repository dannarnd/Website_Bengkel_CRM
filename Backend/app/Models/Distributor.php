<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id_distributor)) {
                $latest = self::orderBy('id_distributor', 'desc')->first();
                if (!$latest) {
                    $model->id_distributor = 'D001';
                } else {
                    $number = intval(substr($latest->id_distributor, 1)) + 1;
                    $model->id_distributor = 'D' . str_pad($number, 3, '0', STR_PAD_LEFT);
                }
            }
        });
    }

    protected $table = 'distributor';
    protected $primaryKey = 'id_distributor';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_distributor', 'nama_distributor', 'alamat', 'no_hp'];
}
