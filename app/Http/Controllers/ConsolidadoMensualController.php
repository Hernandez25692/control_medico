<?php

namespace App\Http\Controllers;

use App\Models\AtencionDiaria;
use App\Models\Concepto;
use App\Models\Medico;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        $medicos = Medico::where('activo', true)->orderBy('nombre')->get();

        $conceptos = Concepto::where('activo', true)
            ->orderBy('orden')
            ->get();

        $registrosResumen = AtencionDiaria::selectRaw('medico_id, concepto_id, SUM(cantidad) as total')
            ->whereBetween('fecha', [$inicio, $fin])
            ->groupBy('medico_id', 'concepto_id')
            ->get()
            ->keyBy(fn($item) => $item->medico_id . '_' . $item->concepto_id);

        $registrosDetalle = AtencionDiaria::whereBetween('fecha', [$inicio, $fin])
            ->get()
            ->keyBy(fn($item) => $item->medico_id . '_' . $item->concepto_id . '_' . $item->fecha->format('j'));

        return view('consolidados.mensual', compact(
            'anio',
            'mes',
            'tipo',
            'diasMes',
            'medicos',
            'conceptos',
            'registrosResumen',
            'registrosDetalle'
        ));
    }
}
