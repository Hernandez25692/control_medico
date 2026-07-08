<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Services\EstadisticasService;
use Illuminate\Http\Request;

class GraficaController extends Controller
{
    public function index(Request $request, EstadisticasService $stats)
    {
        $anio = (int) ($request->anio ?? date('Y'));
        $mes = (int) ($request->mes ?? date('n'));
        $medicoId = $request->medico_id ? (int) $request->medico_id : null;

        $medicos = Medico::where('activo', true)->orderBy('nombre')->get();

        $porMes = $stats->atencionesPorMes($anio, $medicoId);
        $porDia = $stats->atencionesPorDia($anio, $mes, $medicoId);
        $topConceptos = $stats->topConceptos($anio, $mes, $medicoId, 15);
        $topMedicos = $stats->topMedicos($anio, $mes, 15);

        return view('graficas.index', compact(
            'anio',
            'mes',
            'medicoId',
            'medicos',
            'porMes',
            'porDia',
            'topConceptos',
            'topMedicos'
        ));
    }
}
