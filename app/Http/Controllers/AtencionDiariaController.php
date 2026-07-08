<?php

namespace App\Http\Controllers;

use App\Models\AtencionDiaria;
use App\Models\Concepto;
use App\Models\Medico;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Periodo;

class AtencionDiariaController extends Controller
{
    private array $conceptosAutomaticos = [
        19 => [1, 18],
        44 => [45, 50],
    ];

    public function index(Request $request)
    {
        $anio = (int) ($request->anio ?? date('Y'));
        $mes = (int) ($request->mes ?? date('n'));

        $user = Auth::user();

        if ($user->hasRole('Administrador')) {
            $medicos = Medico::where('activo', true)->orderBy('nombre')->get();
            $medicoId = $request->medico_id ?? $medicos->first()?->id;
        } else {
            $medicos = Medico::where('id', $user->medico_id)->get();
            $medicoId = $user->medico_id;
        }

        $conceptos = Concepto::where('activo', true)
            ->orderBy('orden')
            ->get();

        $diasMes = Carbon::create($anio, $mes, 1)->daysInMonth;

        $inicio = Carbon::create($anio, $mes, 1)->startOfMonth()->toDateString();
        $fin = Carbon::create($anio, $mes, 1)->endOfMonth()->toDateString();

        $registros = AtencionDiaria::where('medico_id', $medicoId)
            ->whereBetween('fecha', [$inicio, $fin])
            ->get()
            ->keyBy(function ($item) {
                return $item->concepto_id . '_' . $item->fecha->format('j');
            });
        $periodo = Periodo::firstOrCreate(
            [
                'anio' => $anio,
                'mes' => $mes,
            ],
            [
                'cerrado' => false,
            ]
        );
        return view('atenciones_diarias.index', compact(
            'anio',
            'mes',
            'medicos',
            'medicoId',
            'conceptos',
            'diasMes',
            'registros',
            'periodo'
        ));
    }

    public function guardarCelda(Request $request)
    {
        $request->validate([
            'medico_id' => ['required', 'exists:medicos,id'],
            'concepto_id' => ['required', 'exists:conceptos,id'],
            'anio' => ['required', 'integer'],
            'mes' => ['required', 'integer', 'min:1', 'max:12'],
            'dia' => ['required', 'integer', 'min:1', 'max:31'],
            'cantidad' => ['required', 'integer', 'min:0'],
        ]);
        $periodo = Periodo::where('anio', $request->anio)
            ->where('mes', $request->mes)
            ->first();

        if ($periodo && $periodo->cerrado && Auth::user()->hasRole('Medico')) {
            return response()->json([
                'success' => false,
                'message' => 'Este período está cerrado. No puede modificar registros.',
            ], 423);
        }
        $user = Auth::user();

        if ($user->hasRole('Medico')) {
            $request->merge([
                'medico_id' => $user->medico_id,
            ]);
        }
        $concepto = Concepto::findOrFail($request->concepto_id);

        if (array_key_exists((int) $concepto->orden, $this->conceptosAutomaticos)) {
            return response()->json([
                'success' => false,
                'message' => 'Este concepto es automático y no se puede editar manualmente.',
            ], 422);
        }

        $fecha = Carbon::create($request->anio, $request->mes, $request->dia)->toDateString();

        AtencionDiaria::updateOrCreate(
            [
                'medico_id' => $request->medico_id,
                'concepto_id' => $request->concepto_id,
                'fecha' => $fecha,
            ],
            [
                'cantidad' => $request->cantidad,
                'user_id' => Auth::id(),
            ]
        );

        $automaticos = $this->recalcularAutomaticos($request->medico_id, $fecha);

        return response()->json([
            'success' => true,
            'message' => 'Celda guardada.',
            'automaticos' => $automaticos,
        ]);
    }

    private function recalcularAutomaticos($medicoId, $fecha): array
    {
        $respuesta = [];

        foreach ($this->conceptosAutomaticos as $ordenTotal => [$desde, $hasta]) {
            $conceptoTotal = Concepto::where('orden', $ordenTotal)->first();

            if (!$conceptoTotal) {
                continue;
            }

            $conceptosBase = Concepto::whereBetween('orden', [$desde, $hasta])
                ->pluck('id');

            $total = AtencionDiaria::where('medico_id', $medicoId)
                ->where('fecha', $fecha)
                ->whereIn('concepto_id', $conceptosBase)
                ->sum('cantidad');

            AtencionDiaria::updateOrCreate(
                [
                    'medico_id' => $medicoId,
                    'concepto_id' => $conceptoTotal->id,
                    'fecha' => $fecha,
                ],
                [
                    'cantidad' => $total,
                    'user_id' => Auth::id(),
                ]
            );

            $dia = Carbon::parse($fecha)->format('j');

            $respuesta[] = [
                'concepto_id' => $conceptoTotal->id,
                'dia' => $dia,
                'cantidad' => $total,
            ];
        }

        return $respuesta;
    }
}
