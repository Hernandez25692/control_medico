<?php

namespace App\Http\Controllers;

use App\Models\AtencionDiaria;
use App\Models\Concepto;
use App\Models\Medico;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtencionDiariaController extends Controller
{
    public function index(Request $request)
    {
        $anio = $request->anio ?? date('Y');
        $mes = $request->mes ?? date('m');

        $medicos = Medico::where('activo', true)->orderBy('nombre')->get();

        $medicoId = $request->medico_id ?? $medicos->first()?->id;

        $conceptos = Concepto::where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        $diasMes = Carbon::create($anio, $mes, 1)->daysInMonth;

        $fechaInicio = Carbon::create($anio, $mes, 1)->startOfMonth()->toDateString();
        $fechaFin = Carbon::create($anio, $mes, 1)->endOfMonth()->toDateString();

        $registros = AtencionDiaria::where('medico_id', $medicoId)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->get()
            ->keyBy(function ($item) {
                return $item->concepto_id . '_' . $item->fecha->format('j');
            });

        return view('atenciones_diarias.index', compact(
            'anio',
            'mes',
            'medicos',
            'medicoId',
            'conceptos',
            'diasMes',
            'registros'
        ));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'medico_id' => ['required', 'exists:medicos,id'],
            'anio' => ['required', 'integer', 'min:2020', 'max:2100'],
            'mes' => ['required', 'integer', 'min:1', 'max:12'],
            'datos' => ['nullable', 'array'],
        ]);

        foreach ($request->datos ?? [] as $conceptoId => $dias) {
            foreach ($dias as $dia => $cantidad) {
                $cantidad = (int) $cantidad;

                $fecha = Carbon::create($request->anio, $request->mes, $dia)->toDateString();

                AtencionDiaria::updateOrCreate(
                    [
                        'medico_id' => $request->medico_id,
                        'concepto_id' => $conceptoId,
                        'fecha' => $fecha,
                    ],
                    [
                        'cantidad' => $cantidad,
                        'user_id' => Auth::id(),
                    ]
                );
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Registro mensual guardado correctamente.',
        ]);
    }
}
