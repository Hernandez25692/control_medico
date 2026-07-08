<?php

namespace App\Http\Controllers;

use App\Models\AtencionDiaria;
use App\Models\Concepto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Medico;
use App\Models\Periodo;

class ConsolidadoMensualController extends Controller
{
    public function index(Request $request)
    {
        $anio = (int) ($request->anio ?? date('Y'));
        $mes = (int) ($request->mes ?? date('n'));
        $tipo = $request->tipo ?? 'resumen';

        $inicio = Carbon::create($anio, $mes, 1)->startOfMonth()->toDateString();
        $fin = Carbon::create($anio, $mes, 1)->endOfMonth()->toDateString();
        $diasMes = Carbon::create($anio, $mes, 1)->daysInMonth;

        $conceptos = Concepto::where('activo', true)
            ->orderBy('orden')
            ->get();

        $registrosResumen = AtencionDiaria::selectRaw('concepto_id, SUM(cantidad) as total')
            ->whereBetween('fecha', [$inicio, $fin])
            ->groupBy('concepto_id')
            ->get()
            ->keyBy('concepto_id');

        $registrosDetalle = AtencionDiaria::selectRaw('concepto_id, DAY(fecha) as dia, SUM(cantidad) as total')
            ->whereBetween('fecha', [$inicio, $fin])
            ->groupBy('concepto_id', 'dia')
            ->get()
            ->keyBy(fn($item) => $item->concepto_id . '_' . $item->dia);

        $medicos = Medico::where('activo', true)->orderBy('nombre')->get();

        $registrosPorMedico = AtencionDiaria::selectRaw('medico_id, concepto_id, SUM(cantidad) as total')
            ->whereBetween('fecha', [$inicio, $fin])
            ->groupBy('medico_id', 'concepto_id')
            ->get()
            ->keyBy(fn($item) => $item->medico_id . '_' . $item->concepto_id);
        $periodo = Periodo::where('anio', $anio)
            ->where('mes', $mes)
            ->first();
        return view('consolidados.mensual', compact(
            'anio',
            'mes',
            'tipo',
            'diasMes',
            'conceptos',
            'registrosResumen',
            'registrosDetalle',
            'medicos',
            'registrosPorMedico',
            'periodo'
        ));
    }
}
