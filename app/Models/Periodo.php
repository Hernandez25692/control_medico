<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $fillable = [
        'anio',
        'mes',
        'cerrado',
        'cerrado_por',
        'cerrado_en',
    ];

    protected $casts = [
        'cerrado' => 'boolean',
        'cerrado_en' => 'datetime',
    ];

    public function usuarioCierre()
    {
        return $this->belongsTo(User::class, 'cerrado_por');
    }
}
