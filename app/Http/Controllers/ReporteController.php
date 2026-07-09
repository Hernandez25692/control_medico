<?php

namespace App\Http\Controllers;

use App\Exports\ReporteConsolidadoExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function exportar(Request $request)
    {
        $this->validarReporte($request);

        $nombre = $request->reporte === 'mensual'
            ? "reporte_mensual_{$request->tipo}_{$request->mes}_{$request->anio}.xlsx"
            : "reporte_anual_{$request->tipo}_{$request->anio}.xlsx";

        return Excel::download(
            new ReporteConsolidadoExport(
                $request->reporte,
                $request->tipo,
                (int) $request->anio,
                $request->mes ? (int) $request->mes : null
            ),
            $nombre
        );
    }

    public function vistaPrevia(Request $request)
    {
        $this->validarReporte($request);

        $export = new ReporteConsolidadoExport(
            $request->reporte,
            $request->tipo,
            (int) $request->anio,
            $request->mes ? (int) $request->mes : null
        );

        return view('reportes.preview', [
            'reporte' => $request->reporte,
            'tipo' => $request->tipo,
            'anio' => $request->anio,
            'mes' => $request->mes,
            'encabezados' => $export->headings(),
            'filas' => $export->array(),
        ]);
    }

    private function validarReporte(Request $request)
    {
        $request->validate([
            'reporte' => ['required', 'in:mensual,anual'],
            'tipo' => ['required', 'in:resumen,medico,detalle'],
            'anio' => ['required', 'integer', 'min:2020', 'max:2100'],
            'mes' => ['nullable', 'integer', 'min:1', 'max:12'],
        ]);

        if ($request->reporte === 'mensual' && !$request->mes) {
            abort(422, 'Debe seleccionar un mes para el reporte mensual.');
        }
    }
}
