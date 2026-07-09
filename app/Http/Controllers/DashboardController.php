<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Services\EstadisticasService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request, EstadisticasService $stats)
    {
        $anio = (int) $request->input('anio', now()->year);
        $mes = (int) $request->input('mes', now()->month);

        if ($anio < 2000 || $anio > 2100) {
            $anio = (int) now()->year;
        }

        if ($mes < 1 || $mes > 12) {
            $mes = (int) now()->month;
        }

        $medicoId = $request->filled('medico_id') ? (int) $request->medico_id : null;
        $metaMensual = $request->filled('meta_mensual') ? max(0, (int) $request->meta_mensual) : null;

        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        $medicos = Medico::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $totalMes = (int) $stats->totalAtencionesMes($anio, $mes, $medicoId);
        $totalAnio = (int) $stats->totalAtencionesAnio($anio, $medicoId);
        $promedioDia = (float) $stats->promedioDiarioMes($anio, $mes, $medicoId);

        $porMes = collect($stats->atencionesPorMes($anio, $medicoId));
        $porDia = collect($stats->atencionesPorDia($anio, $mes, $medicoId));
        $topConceptos = collect($stats->topConceptos($anio, $mes, $medicoId));
        $topMedicos = collect($stats->topMedicos($anio, $mes));

        $fechaMes = Carbon::create($anio, $mes, 1);
        $diasDelMes = $fechaMes->daysInMonth;

        $mesAnterior = $fechaMes->copy()->subMonth();
        $totalMesAnterior = (int) $stats->totalAtencionesMes(
            (int) $mesAnterior->year,
            (int) $mesAnterior->month,
            $medicoId
        );

        $variacionMes = $totalMesAnterior > 0
            ? round((($totalMes - $totalMesAnterior) / $totalMesAnterior) * 100, 1)
            : null;

        $chartMesesLabels = collect($meses)->values()->map(fn($nombre) => substr($nombre, 0, 3))->values();

        $chartMesesData = collect(range(1, 12))->map(function ($numeroMes) use ($porMes) {
            return $this->totalDesdeColeccion($porMes, $numeroMes, 'mes');
        })->values();

        $chartDiasLabels = collect(range(1, $diasDelMes))->map(fn($dia) => (string) $dia)->values();

        $chartDiasData = collect(range(1, $diasDelMes))->map(function ($dia) use ($porDia) {
            return $this->totalDesdeColeccion($porDia, $dia, 'dia');
        })->values();

        $chartConceptosLabels = $topConceptos->map(function ($item) {
            $orden = data_get($item, 'concepto.orden');
            $nombre = data_get($item, 'concepto.nombre', 'N/A');

            return Str::limit(($orden ? $orden . ' - ' : '') . $nombre, 36);
        })->values();

        $chartConceptosData = $topConceptos->map(fn($item) => (int) data_get($item, 'total', 0))->values();

        $chartMedicosLabels = $topMedicos->map(function ($item) {
            return Str::limit(data_get($item, 'medico.nombre', 'N/A'), 32);
        })->values();

        $chartMedicosData = $topMedicos->map(fn($item) => (int) data_get($item, 'total', 0))->values();

        $datosDias = collect(range(1, $diasDelMes))->map(function ($dia) use ($porDia) {
            return [
                'dia' => $dia,
                'total' => $this->totalDesdeColeccion($porDia, $dia, 'dia'),
            ];
        });

        $datosMeses = collect(range(1, 12))->map(function ($numeroMes) use ($porMes, $meses) {
            return [
                'mes' => $numeroMes,
                'nombre' => $meses[$numeroMes],
                'total' => $this->totalDesdeColeccion($porMes, $numeroMes, 'mes'),
            ];
        });

        $mejorDia = $datosDias->sortByDesc('total')->first();
        $mejorMes = $datosMeses->sortByDesc('total')->first();

        $mesesConMovimiento = $datosMeses->where('total', '>', 0)->count();
        $promedioMensual = $mesesConMovimiento > 0 ? round($totalAnio / $mesesConMovimiento, 1) : 0;
        $proyeccionAnual = $mesesConMovimiento > 0 ? round(($totalAnio / $mesesConMovimiento) * 12) : 0;

        $cumplimientoMeta = $metaMensual && $metaMensual > 0
            ? round(($totalMes / $metaMensual) * 100, 1)
            : null;

        $topConcepto = $topConceptos->first();
        $topConceptoNombre = data_get($topConcepto, 'concepto.nombre', 'Sin datos');
        $topConceptoCodigo = data_get($topConcepto, 'concepto.orden', '-');
        $topConceptoTotal = (int) data_get($topConcepto, 'total', 0);

        $participacionTopConcepto = $totalMes > 0
            ? round(($topConceptoTotal / $totalMes) * 100, 1)
            : 0;

        $topMedico = $topMedicos->first();
        $topMedicoNombre = data_get($topMedico, 'medico.nombre', 'Sin datos');
        $topMedicoTotal = (int) data_get($topMedico, 'total', 0);
        $totalRankingMedicos = (int) $topMedicos->sum('total');

        $participacionTopMedico = $totalRankingMedicos > 0
            ? round(($topMedicoTotal / $totalRankingMedicos) * 100, 1)
            : 0;

        $resumenMedico = $medicoId
            ? optional($medicos->firstWhere('id', $medicoId))->nombre
            : 'Todos los médicos';

        $lecturaEjecutiva = [];

        if ($totalMes === 0) {
            $lecturaEjecutiva[] = 'No hay atenciones registradas para el filtro seleccionado.';
        } else {
            $lecturaEjecutiva[] = 'El mes registra ' . number_format($totalMes) . ' atenciones para ' . $resumenMedico . '.';

            if (!is_null($variacionMes)) {
                $lecturaEjecutiva[] = $variacionMes >= 0
                    ? 'La actividad subió ' . abs($variacionMes) . '% frente al mes anterior.'
                    : 'La actividad bajó ' . abs($variacionMes) . '% frente al mes anterior.';
            }

            $lecturaEjecutiva[] = 'El concepto con mayor movimiento representa ' . $participacionTopConcepto . '% del total mensual.';
            $lecturaEjecutiva[] = 'El día con mayor carga fue el día ' . ($mejorDia['dia'] ?? '-') . ' con ' . number_format($mejorDia['total'] ?? 0) . ' atenciones.';
        }

        if (!is_null($cumplimientoMeta)) {
            $lecturaEjecutiva[] = $cumplimientoMeta >= 100
                ? 'La meta mensual fue alcanzada. Aquí ya no estamos jugando a la clínica improvisada.'
                : 'La meta mensual lleva un avance de ' . $cumplimientoMeta . '%.';
        }

        return view('dashboard', compact(
            'anio',
            'mes',
            'medicoId',
            'metaMensual',
            'meses',
            'medicos',
            'totalMes',
            'totalAnio',
            'promedioDia',
            'porMes',
            'porDia',
            'topConceptos',
            'topMedicos',
            'diasDelMes',
            'totalMesAnterior',
            'variacionMes',
            'chartMesesLabels',
            'chartMesesData',
            'chartDiasLabels',
            'chartDiasData',
            'chartConceptosLabels',
            'chartConceptosData',
            'chartMedicosLabels',
            'chartMedicosData',
            'mejorDia',
            'mejorMes',
            'promedioMensual',
            'proyeccionAnual',
            'cumplimientoMeta',
            'participacionTopConcepto',
            'topConceptoNombre',
            'topConceptoCodigo',
            'topConceptoTotal',
            'topMedicoNombre',
            'topMedicoTotal',
            'participacionTopMedico',
            'lecturaEjecutiva',
            'resumenMedico'
        ));
    }

    private function totalDesdeColeccion(Collection $coleccion, int $clave, string $campoClave): int
    {
        $directo = $coleccion->get($clave);

        if (!is_null($directo)) {
            return (int) data_get($directo, 'total', 0);
        }

        $encontrado = $coleccion->first(function ($item) use ($clave, $campoClave) {
            return (int) data_get($item, $campoClave, -1) === $clave;
        });

        return (int) data_get($encontrado, 'total', 0);
    }
}
