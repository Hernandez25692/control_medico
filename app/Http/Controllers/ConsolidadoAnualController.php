<?php

namespace App\Http\Controllers;

use App\Models\AtencionDiaria;
use App\Models\Concepto;
use App\Models\Medico;
use Illuminate\Http\Request;
use App\Models\Periodo;

class ConsolidadoAnualController extends Controller
{
    public function index(Request $request)
    {
        $anio = (int) ($request->anio ?? date('Y'));
        $tipo = $request->tipo ?? 'resumen';

        $inicio = $anio . '-01-01';
        $fin = $anio . '-12-31';

        $conceptos = Concepto::where('activo', true)
            ->orderBy('orden')
            ->get();

        $medicos = Medico::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $registrosResumen = AtencionDiaria::selectRaw('concepto_id, SUM(cantidad) as total')
            ->whereBetween('fecha', [$inicio, $fin])
            ->groupBy('concepto_id')
            ->get()
            ->keyBy('concepto_id');

        $registrosPorMedico = AtencionDiaria::selectRaw('medico_id, concepto_id, SUM(cantidad) as total')
            ->whereBetween('fecha', [$inicio, $fin])
            ->groupBy('medico_id', 'concepto_id')
            ->get()
            ->keyBy(fn($item) => $item->medico_id . '_' . $item->concepto_id);

        $registrosDetalle = AtencionDiaria::selectRaw('concepto_id, MONTH(fecha) as mes, SUM(cantidad) as total')
            ->whereBetween('fecha', [$inicio, $fin])
            ->groupBy('concepto_id', 'mes')
            ->get()
            ->keyBy(fn($item) => $item->concepto_id . '_' . $item->mes);

        $cerrados = Periodo::where('anio', $anio)
            ->where('cerrado', true)
            ->count();

        return view('consolidados.anual', compact(
            'anio',
            'tipo',
            'conceptos',
            'medicos',
            'registrosResumen',
            'registrosPorMedico',
            'registrosDetalle',
            'cerrados'
        ));
    }
}
