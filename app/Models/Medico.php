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
}
