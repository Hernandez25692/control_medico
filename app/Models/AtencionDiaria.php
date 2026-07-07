<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtencionDiaria extends Model
{
    protected $table = 'atencion_diarias';

    protected $fillable = [
        'medico_id',
        'concepto_id',
        'fecha',
        'cantidad',
        'user_id',
    ];

    protected $casts = [
        'fecha' => 'date',
        'cantidad' => 'integer',
    ];

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function concepto()
    {
        return $this->belongsTo(Concepto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
