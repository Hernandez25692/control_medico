@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <form method="GET" action="{{ route('dashboard') }}" class="row">
                <div class="col-md-3">
                    <label>Año</label>
                    <input type="number" name="anio" class="form-control" value="{{ $anio }}">
                </div>

                <div class="col-md-3">
                    <label>Mes</label>
                    <select name="mes" class="form-control">
                        @php
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
                        @endphp

                        @foreach ($meses as $numero => $nombre)
                            <option value="{{ $numero }}" {{ (int) $mes === $numero ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Médico</label>
                    <select name="medico_id" class="form-control">
                        <option value="">Todos los médicos</option>
                        @foreach ($medicos as $medico)
                            <option value="{{ $medico->id }}" {{ $medicoId == $medico->id ? 'selected' : '' }}>
                                {{ $medico->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary btn-block">
                        <i class="fas fa-search"></i> Consultar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($totalMes) }}</h3>
                    <p>Atenciones del mes</p>
                </div>
                <div class="icon"><i class="fas fa-notes-medical"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($totalAnio) }}</h3>
                    <p>Atenciones del año</p>
                </div>
                <div class="icon"><i class="fas fa-chart-line"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($promedioDia) }}</h3>
                    <p>Promedio diario</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-day"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $topConceptos->first()?->concepto?->orden ?? '-' }}</h3>
                    <p>Concepto más usado</p>
                </div>
                <div class="icon"><i class="fas fa-list"></i></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Atenciones por mes</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartMeses" height="110"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Top conceptos</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartConceptos" height="240"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Actividad diaria del mes</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartDias" height="110"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Top médicos</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartMedicos" height="240"></canvas>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const mesesLabels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        const datosMeses = [
            @for ($i = 1; $i <= 12; $i++)
                {{ $porMes[$i]->total ?? 0 }},
            @endfor
        ];

        const diasLabels = [
            @for ($i = 1; $i <= \Carbon\Carbon::create($anio, $mes, 1)->daysInMonth; $i++)
                '{{ $i }}',
            @endfor
        ];

        const datosDias = [
            @for ($i = 1; $i <= \Carbon\Carbon::create($anio, $mes, 1)->daysInMonth; $i++)
                {{ $porDia[$i]->total ?? 0 }},
            @endfor
        ];

        const conceptosLabels = [
            @foreach ($topConceptos as $item)
                '{{ Str::limit($item->concepto->nombre ?? 'N/A', 22) }}',
            @endforeach
        ];

        const conceptosData = [
            @foreach ($topConceptos as $item)
                {{ $item->total }},
            @endforeach
        ];

        const medicosLabels = [
            @foreach ($topMedicos as $item)
                '{{ Str::limit($item->medico->nombre ?? 'N/A', 22) }}',
            @endforeach
        ];

        const medicosData = [
            @foreach ($topMedicos as $item)
                {{ $item->total }},
            @endforeach
        ];

        new Chart(document.getElementById('chartMeses'), {
            type: 'line',
            data: {
                labels: mesesLabels,
                datasets: [{
                    label: 'Atenciones',
                    data: datosMeses,
                    tension: 0.35,
                    fill: true
                }]
            }
        });

        new Chart(document.getElementById('chartDias'), {
            type: 'line',
            data: {
                labels: diasLabels,
                datasets: [{
                    label: 'Atenciones por día',
                    data: datosDias,
                    tension: 0.35,
                    fill: true
                }]
            }
        });

        new Chart(document.getElementById('chartConceptos'), {
            type: 'bar',
            data: {
                labels: conceptosLabels,
                datasets: [{
                    label: 'Total',
                    data: conceptosData
                }]
            },
            options: {
                indexAxis: 'y'
            }
        });

        new Chart(document.getElementById('chartMedicos'), {
            type: 'bar',
            data: {
                labels: medicosLabels,
                datasets: [{
                    label: 'Total',
                    data: medicosData
                }]
            },
            options: {
                indexAxis: 'y'
            }
        });
    </script>
@stop
