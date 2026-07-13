<?php

namespace App\Services;

use App\Models\AtencionDiaria;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EstadisticasService
{
    /**
     * La fila 19 es la única fuente oficial para contar pacientes.
     */
    private const ORDEN_TOTAL_PACIENTES = 19;

    /**
     * La fila 44 corresponde al total automático de menores de 5 años.
     */
    private const ORDEN_TOTAL_MENORES_5 = 44;

    public function totalAtencionesMes(
        int $anio,
        int $mes,
        ?int $medicoId = null
    ): int {
        [$inicio, $fin] = $this->rangoMes($anio, $mes);

        return $this->consultaTotalPacientes($medicoId)
            ->whereBetween('atencion_diarias.fecha', [$inicio, $fin])
            ->sum('atencion_diarias.cantidad');
    }

    public function totalAtencionesAnio(
        int $anio,
        ?int $medicoId = null
    ): int {
        $inicio = Carbon::create($anio, 1, 1)->startOfYear()->toDateString();
        $fin = Carbon::create($anio, 12, 31)->endOfYear()->toDateString();

        return $this->consultaTotalPacientes($medicoId)
            ->whereBetween('atencion_diarias.fecha', [$inicio, $fin])
            ->sum('atencion_diarias.cantidad');
    }

    public function totalMenoresCincoMes(
        int $anio,
        int $mes,
        ?int $medicoId = null
    ): int {
        [$inicio, $fin] = $this->rangoMes($anio, $mes);

        return AtencionDiaria::query()
            ->join('conceptos', 'conceptos.id', '=', 'atencion_diarias.concepto_id')
            ->where('conceptos.orden', self::ORDEN_TOTAL_MENORES_5)
            ->whereBetween('atencion_diarias.fecha', [$inicio, $fin])
            ->when(
                $medicoId,
                fn(Builder $query) => $query->where(
                    'atencion_diarias.medico_id',
                    $medicoId
                )
            )
            ->sum('atencion_diarias.cantidad');
    }

    /**
     * Promedio basado en días laborables transcurridos.
     *
     * En meses anteriores usa todos los lunes a viernes del mes.
     * En el mes actual solamente cuenta hasta hoy.
     */
    public function promedioDiarioMes(
        int $anio,
        int $mes,
        ?int $medicoId = null
    ): float {
        $total = $this->totalAtencionesMes($anio, $mes, $medicoId);
        $diasLaborables = $this->diasLaborablesEvaluados($anio, $mes);

        return $diasLaborables > 0
            ? round($total / $diasLaborables, 1)
            : 0;
    }

    public function atencionesPorMes(
        int $anio,
        ?int $medicoId = null
    ): Collection {
        return $this->consultaTotalPacientes($medicoId)
            ->selectRaw('MONTH(atencion_diarias.fecha) AS mes')
            ->selectRaw('SUM(atencion_diarias.cantidad) AS total')
            ->whereYear('atencion_diarias.fecha', $anio)
            ->groupByRaw('MONTH(atencion_diarias.fecha)')
            ->orderByRaw('MONTH(atencion_diarias.fecha)')
            ->get()
            ->keyBy(fn($item) => (int) $item->mes);
    }

    /**
     * Carga diaria: exclusivamente lunes a viernes.
     */
    public function atencionesPorDia(
        int $anio,
        int $mes,
        ?int $medicoId = null
    ): Collection {
        [$inicio, $fin] = $this->rangoMes($anio, $mes);

        return $this->consultaTotalPacientes($medicoId)
            ->selectRaw('DAY(atencion_diarias.fecha) AS dia')
            ->selectRaw('SUM(atencion_diarias.cantidad) AS total')
            ->whereBetween('atencion_diarias.fecha', [$inicio, $fin])
            ->whereRaw('WEEKDAY(atencion_diarias.fecha) BETWEEN 0 AND 4')
            ->groupByRaw('DAY(atencion_diarias.fecha)')
            ->orderByRaw('DAY(atencion_diarias.fecha)')
            ->get()
            ->keyBy(fn($item) => (int) $item->dia);
    }

    /**
     * Conceptos con movimiento.
     *
     * Se eliminan las filas 19 y 44 porque son totales automáticos.
     */
    public function topConceptos(
        int $anio,
        int $mes,
        ?int $medicoId = null,
        int $limite = 8
    ): Collection {
        [$inicio, $fin] = $this->rangoMes($anio, $mes);

        return AtencionDiaria::query()
            ->select(
                'conceptos.id',
                'conceptos.orden',
                'conceptos.nombre'
            )
            ->selectRaw('SUM(atencion_diarias.cantidad) AS total')
            ->join('conceptos', 'conceptos.id', '=', 'atencion_diarias.concepto_id')
            ->whereBetween('atencion_diarias.fecha', [$inicio, $fin])
            ->whereRaw('WEEKDAY(atencion_diarias.fecha) BETWEEN 0 AND 4')
            ->whereNotIn('conceptos.orden', [
                self::ORDEN_TOTAL_PACIENTES,
                self::ORDEN_TOTAL_MENORES_5,
            ])
            ->when(
                $medicoId,
                fn(Builder $query) => $query->where(
                    'atencion_diarias.medico_id',
                    $medicoId
                )
            )
            ->groupBy(
                'conceptos.id',
                'conceptos.orden',
                'conceptos.nombre'
            )
            ->havingRaw('SUM(atencion_diarias.cantidad) > 0')
            ->orderByDesc('total')
            ->limit($limite)
            ->get()
            ->map(function ($item) {
                return [
                    'concepto' => [
                        'id' => (int) $item->id,
                        'orden' => (int) $item->orden,
                        'nombre' => $item->nombre,
                    ],
                    'total' => (int) $item->total,
                ];
            });
    }

    /**
     * Ranking real de médicos: solo Total de Pacientes Atendidos.
     */
    public function topMedicos(
        int $anio,
        int $mes,
        int $limite = 8
    ): Collection {
        [$inicio, $fin] = $this->rangoMes($anio, $mes);

        return AtencionDiaria::query()
            ->select(
                'medicos.id',
                'medicos.nombre'
            )
            ->selectRaw('SUM(atencion_diarias.cantidad) AS total')
            ->join('conceptos', 'conceptos.id', '=', 'atencion_diarias.concepto_id')
            ->join('medicos', 'medicos.id', '=', 'atencion_diarias.medico_id')
            ->where('conceptos.orden', self::ORDEN_TOTAL_PACIENTES)
            ->whereBetween('atencion_diarias.fecha', [$inicio, $fin])
            ->whereRaw('WEEKDAY(atencion_diarias.fecha) BETWEEN 0 AND 4')
            ->groupBy(
                'medicos.id',
                'medicos.nombre'
            )
            ->havingRaw('SUM(atencion_diarias.cantidad) > 0')
            ->orderByDesc('total')
            ->limit($limite)
            ->get()
            ->map(function ($item) {
                return [
                    'medico' => [
                        'id' => (int) $item->id,
                        'nombre' => $item->nombre,
                    ],
                    'total' => (int) $item->total,
                ];
            });
    }

    public function diasLaborablesMes(int $anio, int $mes): int
    {
        $fecha = Carbon::create($anio, $mes, 1)->startOfMonth();
        $fin = $fecha->copy()->endOfMonth();
        $total = 0;

        while ($fecha->lte($fin)) {
            if ($fecha->isWeekday()) {
                $total++;
            }

            $fecha->addDay();
        }

        return $total;
    }

    public function diasLaborablesEvaluados(int $anio, int $mes): int
    {
        $inicio = Carbon::create($anio, $mes, 1)->startOfMonth();
        $finMes = $inicio->copy()->endOfMonth();
        $hoy = now()->startOfDay();

        if ($inicio->isFuture()) {
            return $this->diasLaborablesMes($anio, $mes);
        }

        $finEvaluado = $finMes->isPast()
            ? $finMes
            : $hoy->min($finMes);

        $fecha = $inicio->copy();
        $total = 0;

        while ($fecha->lte($finEvaluado)) {
            if ($fecha->isWeekday()) {
                $total++;
            }

            $fecha->addDay();
        }

        return $total;
    }

    public function diasConAtencion(
        int $anio,
        int $mes,
        ?int $medicoId = null
    ): int {
        [$inicio, $fin] = $this->rangoMes($anio, $mes);

        return $this->consultaTotalPacientes($medicoId)
            ->whereBetween('atencion_diarias.fecha', [$inicio, $fin])
            ->whereRaw('WEEKDAY(atencion_diarias.fecha) BETWEEN 0 AND 4')
            ->where('atencion_diarias.cantidad', '>', 0)
            ->distinct()
            ->count('atencion_diarias.fecha');
    }

    public function registrosFinSemana(
        int $anio,
        int $mes,
        ?int $medicoId = null
    ): int {
        [$inicio, $fin] = $this->rangoMes($anio, $mes);

        return $this->consultaTotalPacientes($medicoId)
            ->whereBetween('atencion_diarias.fecha', [$inicio, $fin])
            ->whereRaw('WEEKDAY(atencion_diarias.fecha) IN (5, 6)')
            ->sum('atencion_diarias.cantidad');
    }

    private function consultaTotalPacientes(?int $medicoId = null): Builder
    {
        return AtencionDiaria::query()
            ->join('conceptos', 'conceptos.id', '=', 'atencion_diarias.concepto_id')
            ->where('conceptos.orden', self::ORDEN_TOTAL_PACIENTES)
            ->when(
                $medicoId,
                fn(Builder $query) => $query->where(
                    'atencion_diarias.medico_id',
                    $medicoId
                )
            );
    }

    private function rangoMes(int $anio, int $mes): array
    {
        $fecha = Carbon::create($anio, $mes, 1);

        return [
            $fecha->copy()->startOfMonth()->toDateString(),
            $fecha->copy()->endOfMonth()->toDateString(),
        ];
    }
}
