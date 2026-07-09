<?php

namespace App\Http\Controllers;

use App\Models\AuditoriaAtencion;
use App\Models\Medico;
use Illuminate\Http\Request;

class AuditoriaAtencionController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditoriaAtencion::with([
            'medico',
            'concepto',
            'usuario'
        ]);

        if ($request->filled('medico_id')) {
            $query->where('medico_id', $request->medico_id);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        $auditorias = $query
            ->latest()
            ->paginate(50)
            ->withQueryString();

        $medicos = Medico::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view(
            'auditoria_atenciones.index',
            compact(
                'auditorias',
                'medicos'
            )
        );
    }
}
