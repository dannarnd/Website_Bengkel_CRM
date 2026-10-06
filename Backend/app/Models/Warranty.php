<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    protected $table = 'warranty';
    
    protected $guarded = ['id'];

    // Garansi ini milik nota servis yang mana
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
