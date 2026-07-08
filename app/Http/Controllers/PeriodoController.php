<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriodoController extends Controller
{
    public function index(Request $request)
    {
        $anio = (int) ($request->anio ?? date('Y'));

        $periodos = collect(range(1, 12))->map(function ($mes) use ($anio) {
            return Periodo::firstOrCreate(
                ['anio' => $anio, 'mes' => $mes],
                ['cerrado' => false]
            );
        });

        return view('periodos.index', compact('anio', 'periodos'));
    }

    public function cambiarEstado(Periodo $periodo)
    {
        if ($periodo->cerrado) {
            $periodo->update([
                'cerrado' => false,
                'cerrado_por' => null,
                'cerrado_en' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Período reabierto correctamente.',
            ]);
        }

        $periodo->update([
            'cerrado' => true,
            'cerrado_por' => Auth::id(),
            'cerrado_en' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Período cerrado correctamente.',
        ]);
    }
}
