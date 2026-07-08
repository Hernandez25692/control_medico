<?php

namespace App\Services;

use App\Models\AtencionDiaria;
use App\Models\Concepto;
use App\Models\Medico;
use Carbon\Carbon;

class EstadisticasService
{
    public function totalAtencionesMes(int $anio, int $mes, ?int $medicoId = null): int
    {
        $query = AtencionDiaria::whereYear('fecha', $anio)
            ->whereMonth('fecha', $mes)
            ->whereHas('concepto', function ($q) {
                $q->whereNotIn('orden', [19, 44]);
            });

        if ($medicoId) {
            $query->where('medico_id', $medicoId);
        }

        return (int) $query->sum('cantidad');
    }

    public function totalAtencionesAnio(int $anio, ?int $medicoId = null): int
    {
        $query = AtencionDiaria::whereYear('fecha', $anio)
            ->whereHas('concepto', function ($q) {
                $q->whereNotIn('orden', [19, 44]);
            });

        if ($medicoId) {
            $query->where('medico_id', $medicoId);
        }

        return (int) $query->sum('cantidad');
    }

    public function atencionesPorMes(int $anio, ?int $medicoId = null)
    {
        $query = AtencionDiaria::selectRaw('MONTH(fecha) as mes, SUM(cantidad) as total')
            ->whereYear('fecha', $anio)
            ->whereHas('concepto', function ($q) {
                $q->whereNotIn('orden', [19, 44]);
            })
            ->groupBy('mes');

        if ($medicoId) {
            $query->where('medico_id', $medicoId);
        }

        return $query->get()->keyBy('mes');
    }

    public function atencionesPorDia(int $anio, int $mes, ?int $medicoId = null)
    {
        $query = AtencionDiaria::selectRaw('DAY(fecha) as dia, SUM(cantidad) as total')
            ->whereYear('fecha', $anio)
            ->whereMonth('fecha', $mes)
            ->whereHas('concepto', function ($q) {
                $q->whereNotIn('orden', [19, 44]);
            })
            ->groupBy('dia');

        if ($medicoId) {
            $query->where('medico_id', $medicoId);
        }

        return $query->get()->keyBy('dia');
    }

    public function topConceptos(int $anio, int $mes, ?int $medicoId = null, int $limite = 10)
    {
        $query = AtencionDiaria::selectRaw('concepto_id, SUM(cantidad) as total')
            ->with('concepto')
            ->whereYear('fecha', $anio)
            ->whereMonth('fecha', $mes)
            ->whereHas('concepto', function ($q) {
                $q->whereNotIn('orden', [19, 44]);
            })
            ->groupBy('concepto_id')
            ->orderByDesc('total')
            ->limit($limite);

        if ($medicoId) {
            $query->where('medico_id', $medicoId);
        }

        return $query->get();
    }

    public function topMedicos(int $anio, int $mes, int $limite = 10)
    {
        return AtencionDiaria::selectRaw('medico_id, SUM(cantidad) as total')
            ->with('medico')
            ->whereYear('fecha', $anio)
            ->whereMonth('fecha', $mes)
            ->whereHas('concepto', function ($q) {
                $q->whereNotIn('orden', [19, 44]);
            })
            ->groupBy('medico_id')
            ->orderByDesc('total')
            ->limit($limite)
            ->get();
    }

    public function promedioDiarioMes(int $anio, int $mes, ?int $medicoId = null): int
    {
        $diasMes = Carbon::create($anio, $mes, 1)->daysInMonth;
        $total = $this->totalAtencionesMes($anio, $mes, $medicoId);

        return $diasMes > 0 ? round($total / $diasMes) : 0;
    }

    public function totalMedicosActivos(): int
    {
        return Medico::where('activo', true)->count();
    }

    public function totalConceptosActivos(): int
    {
        return Concepto::where('activo', true)->count();
    }
}
