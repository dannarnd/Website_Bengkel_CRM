<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    protected $table = 'warranty';
    protected $primaryKey = 'id_warranty';

    protected $fillable = ['id_service', 'tanggal_selesai', 'status'];
}
