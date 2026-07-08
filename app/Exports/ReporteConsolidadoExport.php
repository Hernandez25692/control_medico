<?php

namespace App\Exports;

use App\Models\AtencionDiaria;
use App\Models\Concepto;
use App\Models\Medico;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteConsolidadoExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function __construct(
        private string $reporte,
        private string $tipo,
        private int $anio,
        private ?int $mes = null
    ) {}

    public function headings(): array
    {
        if ($this->reporte === 'mensual') {
            if ($this->tipo === 'detalle') {
                $dias = Carbon::create($this->anio, $this->mes, 1)->daysInMonth;
                return array_merge(['Nº', 'Concepto'], range(1, $dias), ['Total Mes']);
            }

            if ($this->tipo === 'medico') {
                $medicos = Medico::where('activo', true)->orderBy('nombre')->pluck('nombre')->toArray();
                return array_merge(['Nº', 'Concepto'], $medicos, ['Total General']);
            }

            return ['Nº', 'Concepto', 'Total Mes'];
        }

        if ($this->tipo === 'detalle') {
            return ['Nº', 'Concepto', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre', 'Total Anual'];
        }

        if ($this->tipo === 'medico') {
            $medicos = Medico::where('activo', true)->orderBy('nombre')->pluck('nombre')->toArray();
            return array_merge(['Nº', 'Concepto'], $medicos, ['Total General']);
        }

        return ['Nº', 'Concepto', 'Total Anual'];
    }

    public function array(): array
    {
        return $this->reporte === 'mensual'
            ? $this->mensual()
            : $this->anual();
    }

    private function conceptos()
    {
        return Concepto::where('activo', true)->orderBy('orden')->get();
    }

    private function mensual(): array
    {
        return match ($this->tipo) {
            'detalle' => $this->mensualDetalle(),
            'medico' => $this->mensualMedico(),
            default => $this->mensualResumen(),
        };
    }

    private function anual(): array
    {
        return match ($this->tipo) {
            'detalle' => $this->anualDetalle(),
            'medico' => $this->anualMedico(),
            default => $this->anualResumen(),
        };
    }

    private function mensualResumen(): array
    {
        $inicio = Carbon::create($this->anio, $this->mes, 1)->startOfMonth();
        $fin = Carbon::create($this->anio, $this->mes, 1)->endOfMonth();

        $datos = AtencionDiaria::selectRaw('concepto_id, SUM(cantidad) total')
            ->whereBetween('fecha', [$inicio, $fin])
            ->groupBy('concepto_id')
            ->get()
            ->keyBy('concepto_id');

        return $this->conceptos()->map(fn($c) => [
            $c->orden,
            $c->nombre,
            $datos[$c->id]->total ?? 0,
        ])->toArray();
    }

    private function mensualDetalle(): array
    {
        $dias = Carbon::create($this->anio, $this->mes, 1)->daysInMonth;
        $inicio = Carbon::create($this->anio, $this->mes, 1)->startOfMonth();
        $fin = Carbon::create($this->anio, $this->mes, 1)->endOfMonth();

        $datos = AtencionDiaria::selectRaw('concepto_id, DAY(fecha) dia, SUM(cantidad) total')
            ->whereBetween('fecha', [$inicio, $fin])
            ->groupBy('concepto_id', 'dia')
            ->get()
            ->keyBy(fn($i) => $i->concepto_id . '_' . $i->dia);

        $filas = [];

        foreach ($this->conceptos() as $c) {
            $fila = [$c->orden, $c->nombre];
            $total = 0;

            for ($d = 1; $d <= $dias; $d++) {
                $valor = $datos[$c->id . '_' . $d]->total ?? 0;
                $fila[] = $valor;
                $total += $valor;
            }

            $fila[] = $total;
            $filas[] = $fila;
        }

        return $filas;
    }

    private function mensualMedico(): array
    {
        $inicio = Carbon::create($this->anio, $this->mes, 1)->startOfMonth();
        $fin = Carbon::create($this->anio, $this->mes, 1)->endOfMonth();
        $medicos = Medico::where('activo', true)->orderBy('nombre')->get();

        $datos = AtencionDiaria::selectRaw('medico_id, concepto_id, SUM(cantidad) total')
            ->whereBetween('fecha', [$inicio, $fin])
            ->groupBy('medico_id', 'concepto_id')
            ->get()
            ->keyBy(fn($i) => $i->medico_id . '_' . $i->concepto_id);

        $filas = [];

        foreach ($this->conceptos() as $c) {
            $fila = [$c->orden, $c->nombre];
            $total = 0;

            foreach ($medicos as $m) {
                $valor = $datos[$m->id . '_' . $c->id]->total ?? 0;
                $fila[] = $valor;
                $total += $valor;
            }

            $fila[] = $total;
            $filas[] = $fila;
        }

        return $filas;
    }

    private function anualResumen(): array
    {
        $datos = AtencionDiaria::selectRaw('concepto_id, SUM(cantidad) total')
            ->whereYear('fecha', $this->anio)
            ->groupBy('concepto_id')
            ->get()
            ->keyBy('concepto_id');

        return $this->conceptos()->map(fn($c) => [
            $c->orden,
            $c->nombre,
            $datos[$c->id]->total ?? 0,
        ])->toArray();
    }

    private function anualDetalle(): array
    {
        $datos = AtencionDiaria::selectRaw('concepto_id, MONTH(fecha) mes, SUM(cantidad) total')
            ->whereYear('fecha', $this->anio)
            ->groupBy('concepto_id', 'mes')
            ->get()
            ->keyBy(fn($i) => $i->concepto_id . '_' . $i->mes);

        $filas = [];

        foreach ($this->conceptos() as $c) {
            $fila = [$c->orden, $c->nombre];
            $total = 0;

            for ($m = 1; $m <= 12; $m++) {
                $valor = $datos[$c->id . '_' . $m]->total ?? 0;
                $fila[] = $valor;
                $total += $valor;
            }

            $fila[] = $total;
            $filas[] = $fila;
        }

        return $filas;
    }

    private function anualMedico(): array
    {
        $medicos = Medico::where('activo', true)->orderBy('nombre')->get();

        $datos = AtencionDiaria::selectRaw('medico_id, concepto_id, SUM(cantidad) total')
            ->whereYear('fecha', $this->anio)
            ->groupBy('medico_id', 'concepto_id')
            ->get()
            ->keyBy(fn($i) => $i->medico_id . '_' . $i->concepto_id);

        $filas = [];

        foreach ($this->conceptos() as $c) {
            $fila = [$c->orden, $c->nombre];
            $total = 0;

            foreach ($medicos as $m) {
                $valor = $datos[$m->id . '_' . $c->id]->total ?? 0;
                $fila[] = $valor;
                $total += $valor;
            }

            $fila[] = $total;
            $filas[] = $fila;
        }

        return $filas;
    }
}
