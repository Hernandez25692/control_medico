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
    public function index(
        Request $request,
        EstadisticasService $stats
    ) {
        /*
        |--------------------------------------------------------------------------
        | Filtros
        |--------------------------------------------------------------------------
        */

        $anio = (int) $request->input('anio', now()->year);
        $mes = (int) $request->input('mes', now()->month);

        if ($anio < 2000 || $anio > 2100) {
            $anio = (int) now()->year;
        }

        if ($mes < 1 || $mes > 12) {
            $mes = (int) now()->month;
        }

        $medicoId = $request->filled('medico_id')
            ? (int) $request->input('medico_id')
            : null;

        $metaMensual = $request->filled('meta_mensual')
            ? max(0, (int) $request->input('meta_mensual'))
            : null;

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

        $medicos = Medico::query()
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Indicadores principales
        |--------------------------------------------------------------------------
        | EstadisticasService debe contar pacientes únicamente desde el concepto
        | con orden 19: Total de Pacientes Atendidos.
        */

        $totalMes = (int) $stats->totalAtencionesMes(
            $anio,
            $mes,
            $medicoId
        );

        $totalAnio = (int) $stats->totalAtencionesAnio(
            $anio,
            $medicoId
        );

        $promedioDia = (float) $stats->promedioDiarioMes(
            $anio,
            $mes,
            $medicoId
        );

        $totalMenoresCinco = (int) $stats->totalMenoresCincoMes(
            $anio,
            $mes,
            $medicoId
        );

        /*
        |--------------------------------------------------------------------------
        | Datos para gráficos
        |--------------------------------------------------------------------------
        */

        $porMes = collect(
            $stats->atencionesPorMes($anio, $medicoId)
        );

        $porDia = collect(
            $stats->atencionesPorDia($anio, $mes, $medicoId)
        );

        $topConceptos = collect(
            $stats->topConceptos($anio, $mes, $medicoId)
        );

        $topMedicos = collect(
            $stats->topMedicos($anio, $mes)
        );

        /*
        |--------------------------------------------------------------------------
        | Días laborables
        |--------------------------------------------------------------------------
        */

        $fechaMes = Carbon::create($anio, $mes, 1);

        $diasDelMes = $fechaMes->daysInMonth;

        $diasLaborablesMes = (int) $stats->diasLaborablesMes(
            $anio,
            $mes
        );

        $diasLaborablesEvaluados = (int) $stats->diasLaborablesEvaluados(
            $anio,
            $mes
        );

        $diasConAtencion = (int) $stats->diasConAtencion(
            $anio,
            $mes,
            $medicoId
        );

        $diasSinRegistro = max(
            0,
            $diasLaborablesEvaluados - $diasConAtencion
        );

        $coberturaRegistro = $diasLaborablesEvaluados > 0
            ? round(
                ($diasConAtencion / $diasLaborablesEvaluados) * 100,
                1
            )
            : 0;

        $promedioPorDiaConActividad = $diasConAtencion > 0
            ? round($totalMes / $diasConAtencion, 1)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Calidad de datos
        |--------------------------------------------------------------------------
        */

        $registrosFinSemana = (int) $stats->registrosFinSemana(
            $anio,
            $mes,
            $medicoId
        );

        /*
        |--------------------------------------------------------------------------
        | Proyección mensual
        |--------------------------------------------------------------------------
        | Para meses en curso se proyecta usando los días laborables transcurridos.
        | Para meses cerrados la proyección coincidirá con el resultado real.
        */

        $proyeccionMensual = $diasLaborablesEvaluados > 0
            ? (int) round(
                ($totalMes / $diasLaborablesEvaluados)
                    * $diasLaborablesMes
            )
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Comparación contra mes anterior
        |--------------------------------------------------------------------------
        */

        $mesAnterior = $fechaMes->copy()->subMonth();

        $totalMesAnterior = (int) $stats->totalAtencionesMes(
            (int) $mesAnterior->year,
            (int) $mesAnterior->month,
            $medicoId
        );

        $variacionMes = $totalMesAnterior > 0
            ? round(
                (
                    ($totalMes - $totalMesAnterior)
                    / $totalMesAnterior
                ) * 100,
                1
            )
            : null;

        /*
        |--------------------------------------------------------------------------
        | Gráfico anual
        |--------------------------------------------------------------------------
        */

        $chartMesesLabels = collect($meses)
            ->values()
            ->map(
                fn(string $nombre) => mb_substr($nombre, 0, 3)
            )
            ->values();

        $chartMesesData = collect(range(1, 12))
            ->map(function (int $numeroMes) use ($porMes) {
                return $this->totalDesdeColeccion(
                    $porMes,
                    $numeroMes,
                    'mes'
                );
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Gráfico diario
        |--------------------------------------------------------------------------
        | Se muestran solamente lunes a viernes.
        */

        $diasLaborables = collect(range(1, $diasDelMes))
            ->filter(function (int $dia) use ($anio, $mes) {
                return Carbon::create(
                    $anio,
                    $mes,
                    $dia
                )->isWeekday();
            })
            ->values();

        $chartDiasLabels = $diasLaborables
            ->map(
                fn(int $dia) => (string) $dia
            )
            ->values();

        $chartDiasData = $diasLaborables
            ->map(function (int $dia) use ($porDia) {
                return $this->totalDesdeColeccion(
                    $porDia,
                    $dia,
                    'dia'
                );
            })
            ->values();

        $datosDias = $diasLaborables
            ->map(function (int $dia) use ($porDia) {
                return [
                    'dia' => $dia,
                    'total' => $this->totalDesdeColeccion(
                        $porDia,
                        $dia,
                        'dia'
                    ),
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Gráfico de conceptos
        |--------------------------------------------------------------------------
        */

        $chartConceptosLabels = $topConceptos
            ->map(function ($item) {
                $orden = data_get(
                    $item,
                    'concepto.orden'
                );

                $nombre = data_get(
                    $item,
                    'concepto.nombre',
                    'Sin nombre'
                );

                $etiqueta = $orden
                    ? $orden . ' - ' . $nombre
                    : $nombre;

                return Str::limit($etiqueta, 42);
            })
            ->values();

        $chartConceptosData = $topConceptos
            ->map(
                fn($item) => (int) data_get(
                    $item,
                    'total',
                    0
                )
            )
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Gráfico de médicos
        |--------------------------------------------------------------------------
        */

        $chartMedicosLabels = $topMedicos
            ->map(function ($item) {
                return Str::limit(
                    data_get(
                        $item,
                        'medico.nombre',
                        'Sin nombre'
                    ),
                    35
                );
            })
            ->values();

        $chartMedicosData = $topMedicos
            ->map(
                fn($item) => (int) data_get(
                    $item,
                    'total',
                    0
                )
            )
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Mes de mayor atención
        |--------------------------------------------------------------------------
        */

        $datosMeses = collect(range(1, 12))
            ->map(function (int $numeroMes) use (
                $porMes,
                $meses
            ) {
                return [
                    'mes' => $numeroMes,
                    'nombre' => $meses[$numeroMes],
                    'total' => $this->totalDesdeColeccion(
                        $porMes,
                        $numeroMes,
                        'mes'
                    ),
                ];
            });

        $mejorDia = $datosDias
            ->filter(
                fn(array $item) => $item['total'] > 0
            )
            ->sortByDesc('total')
            ->first();

        $mejorDia = $mejorDia ?? [
            'dia' => '-',
            'total' => 0,
        ];

        $mejorMes = $datosMeses
            ->filter(
                fn(array $item) => $item['total'] > 0
            )
            ->sortByDesc('total')
            ->first();

        $mejorMes = $mejorMes ?? [
            'mes' => null,
            'nombre' => '-',
            'total' => 0,
        ];

        /*
        |--------------------------------------------------------------------------
        | Promedio y proyección anual
        |--------------------------------------------------------------------------
        */

        $mesesConMovimiento = $datosMeses
            ->where('total', '>', 0)
            ->count();

        $promedioMensual = $mesesConMovimiento > 0
            ? round(
                $totalAnio / $mesesConMovimiento,
                1
            )
            : 0;

        $proyeccionAnual = $mesesConMovimiento > 0
            ? (int) round(
                ($totalAnio / $mesesConMovimiento) * 12
            )
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Meta mensual
        |--------------------------------------------------------------------------
        */

        $cumplimientoMeta = $metaMensual !== null
            && $metaMensual > 0
            ? round(
                ($totalMes / $metaMensual) * 100,
                1
            )
            : null;

        /*
        |--------------------------------------------------------------------------
        | Concepto con mayor movimiento
        |--------------------------------------------------------------------------
        | No representa pacientes únicos. Es un indicador operativo de los
        | servicios o categorías con mayor cantidad registrada.
        */

        $topConcepto = $topConceptos->first();

        $topConceptoNombre = data_get(
            $topConcepto,
            'concepto.nombre',
            'Sin datos'
        );

        $topConceptoCodigo = data_get(
            $topConcepto,
            'concepto.orden',
            '-'
        );

        $topConceptoTotal = (int) data_get(
            $topConcepto,
            'total',
            0
        );

        $participacionTopConcepto = $totalMes > 0
            ? round(
                ($topConceptoTotal / $totalMes) * 100,
                1
            )
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Médico con mayor volumen
        |--------------------------------------------------------------------------
        | La participación se compara contra el total institucional, no contra
        | la suma parcial de los médicos incluidos en el top.
        */

        $topMedico = $topMedicos->first();

        $topMedicoNombre = data_get(
            $topMedico,
            'medico.nombre',
            'Sin datos'
        );

        $topMedicoTotal = (int) data_get(
            $topMedico,
            'total',
            0
        );

        $participacionTopMedico = $totalMes > 0
            ? round(
                ($topMedicoTotal / $totalMes) * 100,
                1
            )
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Médico seleccionado
        |--------------------------------------------------------------------------
        */

        $medicoSeleccionado = $medicoId
            ? $medicos->firstWhere('id', $medicoId)
            : null;

        $resumenMedico = $medicoSeleccionado
            ? $medicoSeleccionado->nombre
            : 'Todos los médicos';

        /*
        |--------------------------------------------------------------------------
        | Lectura ejecutiva
        |--------------------------------------------------------------------------
        */

        $lecturaEjecutiva = [];

        if ($totalMes === 0) {
            $lecturaEjecutiva[] =
                'No hay pacientes atendidos registrados para el filtro seleccionado.';
        } else {
            $lecturaEjecutiva[] =
                'Se registran '
                . number_format($totalMes)
                . ' pacientes atendidos para '
                . $resumenMedico
                . '.';

            $lecturaEjecutiva[] =
                'El promedio es de '
                . number_format($promedioDia, 1)
                . ' pacientes por día laborable evaluado.';

            $lecturaEjecutiva[] =
                'Se reportó atención en '
                . $diasConAtencion
                . ' de '
                . $diasLaborablesEvaluados
                . ' días laborables evaluados.';

            if ($diasSinRegistro > 0) {
                $lecturaEjecutiva[] =
                    'Existen '
                    . $diasSinRegistro
                    . ' días laborables sin pacientes registrados.';
            }

            if (!is_null($variacionMes)) {
                if ($variacionMes > 0) {
                    $lecturaEjecutiva[] =
                        'La atención aumentó '
                        . abs($variacionMes)
                        . '% respecto al mes anterior.';
                } elseif ($variacionMes < 0) {
                    $lecturaEjecutiva[] =
                        'La atención disminuyó '
                        . abs($variacionMes)
                        . '% respecto al mes anterior.';
                } else {
                    $lecturaEjecutiva[] =
                        'La atención se mantuvo igual al mes anterior.';
                }
            }

            if (($mejorDia['total'] ?? 0) > 0) {
                $lecturaEjecutiva[] =
                    'La mayor carga ocurrió el día '
                    . $mejorDia['dia']
                    . ' con '
                    . number_format($mejorDia['total'])
                    . ' pacientes atendidos.';
            }

            if ($totalMenoresCinco > 0) {
                $porcentajeMenores = round(
                    ($totalMenoresCinco / $totalMes) * 100,
                    1
                );

                $lecturaEjecutiva[] =
                    'Los menores de cinco años representan '
                    . $porcentajeMenores
                    . '% del total mensual.';
            }
        }



        if (!is_null($cumplimientoMeta)) {
            if ($cumplimientoMeta >= 100) {
                $lecturaEjecutiva[] =
                    'La meta mensual fue alcanzada con un cumplimiento de '
                    . $cumplimientoMeta
                    . '%.';
            } else {
                $lecturaEjecutiva[] =
                    'La meta mensual presenta un avance de '
                    . $cumplimientoMeta
                    . '%.';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Vista
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(
            'anio',
            'mes',
            'medicoId',
            'metaMensual',
            'meses',
            'medicos',

            'totalMes',
            'totalAnio',
            'totalMenoresCinco',
            'promedioDia',

            'porMes',
            'porDia',
            'topConceptos',
            'topMedicos',

            'diasDelMes',
            'diasLaborablesMes',
            'diasLaborablesEvaluados',
            'diasConAtencion',
            'diasSinRegistro',
            'coberturaRegistro',
            'promedioPorDiaConActividad',
            'registrosFinSemana',

            'totalMesAnterior',
            'variacionMes',

            'proyeccionMensual',
            'promedioMensual',
            'proyeccionAnual',

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

            'cumplimientoMeta',

            'topConceptoNombre',
            'topConceptoCodigo',
            'topConceptoTotal',
            'participacionTopConcepto',

            'topMedicoNombre',
            'topMedicoTotal',
            'participacionTopMedico',

            'lecturaEjecutiva',
            'resumenMedico'
        ));
    }

    private function totalDesdeColeccion(
        Collection $coleccion,
        int $clave,
        string $campoClave
    ): int {
        /*
        |--------------------------------------------------------------------------
        | Colección indexada por clave
        |--------------------------------------------------------------------------
        */

        $directo = $coleccion->get($clave);

        if (!is_null($directo)) {
            if (is_numeric($directo)) {
                return (int) $directo;
            }

            return (int) data_get(
                $directo,
                'total',
                0
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Colección sin indexar
        |--------------------------------------------------------------------------
        */

        $encontrado = $coleccion->first(
            function ($item) use ($clave, $campoClave) {
                return (int) data_get(
                    $item,
                    $campoClave,
                    -1
                ) === $clave;
            }
        );

        return (int) data_get(
            $encontrado,
            'total',
            0
        );
    }
}
