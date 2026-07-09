<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Medico extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'codigo',
        'nombre',
        'especialidad',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }

    public static function generarCodigoAutomatico(): string
    {
        $ultimo = self::withTrashed()
            ->where('codigo', 'like', 'MED-%')
            ->orderByRaw("CAST(REPLACE(codigo, 'MED-', '') AS UNSIGNED) DESC")
            ->first();

        if (!$ultimo) {
            return 'MED-0001';
        }

        $numero = (int) str_replace('MED-', '', $ultimo->codigo);
        $siguiente = $numero + 1;

        return 'MED-' . str_pad($siguiente, 4, '0', STR_PAD_LEFT);
    }
}
