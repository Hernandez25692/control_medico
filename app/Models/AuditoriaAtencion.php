<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaAtencion extends Model
{
    protected $table = 'auditoria_atenciones';

    protected $fillable = [
        'atencion_diaria_id',
        'medico_id',
        'concepto_id',
        'fecha',
        'valor_anterior',
        'valor_nuevo',
        'user_id',
        'ip',
        'user_agent',
    ];

    protected $casts = [
        'fecha' => 'date',
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
