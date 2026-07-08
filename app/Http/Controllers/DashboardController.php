<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Services\EstadisticasService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, EstadisticasService $stats)
    {
        $anio = (int) ($request->anio ?? date('Y'));
        $mes = (int) ($request->mes ?? date('n'));
        $medicoId = $request->medico_id ? (int) $request->medico_id : null;

        $medicos = Medico::where('activo', true)->orderBy('nombre')->get();

        $totalMes = $stats->totalAtencionesMes($anio, $mes, $medicoId);
        $totalAnio = $stats->totalAtencionesAnio($anio, $medicoId);
        $promedioDia = $stats->promedioDiarioMes($anio, $mes, $medicoId);

        $porMes = $stats->atencionesPorMes($anio, $medicoId);
        $porDia = $stats->atencionesPorDia($anio, $mes, $medicoId);
        $topConceptos = $stats->topConceptos($anio, $mes, $medicoId);
        $topMedicos = $stats->topMedicos($anio, $mes);

        return view('dashboard', compact(
            'anio',
            'mes',
            'medicoId',
            'medicos',
            'totalMes',
            'totalAnio',
            'promedioDia',
            'porMes',
            'porDia',
            'topConceptos',
            'topMedicos'
        ));
    }
}
