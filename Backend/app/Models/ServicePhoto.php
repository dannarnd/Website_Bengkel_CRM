<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ServicePhoto extends Model
{
    protected $table = 'service_photo';
    protected $primaryKey = 'id_service_photo';

    protected $fillable = ['id_service', 'tipe_foto', 'photo_path'];
}
