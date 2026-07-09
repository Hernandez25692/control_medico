@extends('adminlte::page')

@section('title', 'Centro de Decisiones')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="mb-0 font-weight-bold">Centro de Decisiones</h1>
            <small class="text-muted">
                Indicadores, tendencias, comparativos y generación rápida de reportes médicos.
            </small>
        </div>

        <div class="mt-2 mt-md-0">
            <span class="badge badge-primary p-2">
                <i class="fas fa-calendar-alt mr-1"></i>
                {{ $meses[$mes] ?? $mes }} {{ $anio }}
            </span>
        </div>
    </div>
@stop

@section('css')
    <style>
        .decision-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 45%, #0369a1 100%);
            color: #fff;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 14px 35px rgba(15, 23, 42, .22);
            position: relative;
            overflow: hidden;
        }

        .decision-hero:after {
            content: "";
            position: absolute;
            right: -70px;
            top: -70px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .10);
        }

        .decision-hero h2 {
            font-weight: 800;
            margin-bottom: 4px;
        }

        .filter-card,
        .metric-card,
        .decision-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .08);
        }

        .filter-card .form-control {
            border-radius: 10px;
        }

        .metric-card {
            background: #fff;
            padding: 18px;
            min-height: 150px;
            position: relative;
            overflow: hidden;
            transition: .2s ease-in-out;
        }

        .metric-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(15, 23, 42, .12);
        }

        .metric-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 12px;
        }

        .metric-label {
            font-size: 13px;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .metric-value {
            font-size: 31px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
        }

        .metric-foot {
            font-size: 13px;
            margin-top: 8px;
            color: #64748b;
        }

        .icon-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .icon-green {
            background: #dcfce7;
            color: #15803d;
        }

        .icon-orange {
            background: #ffedd5;
            color: #c2410c;
        }

        .icon-red {
            background: #fee2e2;
            color: #b91c1c;
        }

        .icon-purple {
            background: #ede9fe;
            color: #6d28d9;
        }

        .icon-cyan {
            background: #cffafe;
            color: #0e7490;
        }

        .chart-box {
            height: 340px;
            position: relative;
        }

        .chart-box-sm {
            height: 310px;
            position: relative;
        }

        .decision-list {
            padding-left: 0;
            list-style: none;
            margin-bottom: 0;
        }

        .decision-list li {
            padding: 12px 0;
            border-bottom: 1px solid #edf2f7;
            display: flex;
            gap: 10px;
        }

        .decision-list li:last-child {
            border-bottom: 0;
        }

        .decision-list i {
            color: #2563eb;
            margin-top: 3px;
        }

        .report-card {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 15px;
            height: 100%;
            background: #fff;
            transition: .2s ease-in-out;
        }

        .report-card:hover {
            border-color: #2563eb;
            box-shadow: 0 10px 24px rgba(37, 99, 235, .10);
        }

        .report-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            margin-bottom: 10px;
        }

        .progress-thin {
            height: 9px;
            border-radius: 999px;
        }

        .btn-rounded {
            border-radius: 10px;
        }

        @media (max-width: 767px) {
            .decision-hero {
                padding: 18px;
            }

            .metric-value {
                font-size: 25px;
            }

            .chart-box,
            .chart-box-sm {
                height: 280px;
            }
        }
    </style>
@stop

@section('content')

    @php
        $fmt = fn($numero) => number_format((float) $numero, 0, '.', ',');
        $fmtDecimal = fn($numero) => number_format((float) $numero, 1, '.', ',');
        $mesNombre = $meses[$mes] ?? $mes;

        /*
            Ajusta estas 2 rutas si tu módulo de reportes usa otra URL.
            No afecta el dashboard, solo los botones de generación.
        */
        $rutaPreviewReportes = url('/reportes/consolidado');
        $rutaExcelReportes = url('/reportes/consolidado/exportar');

        $baseParams = [
            'anio' => $anio,
            'mes' => $mes,
        ];

        if ($medicoId) {
            $baseParams['medico_id'] = $medicoId;
        }

        $reportes = [
            [
                'titulo' => 'Mensual detallado',
                'descripcion' => 'Detalle diario por concepto y total del mes.',
                'icono' => 'fas fa-calendar-check',
                'params' => array_merge($baseParams, ['reporte' => 'mensual', 'tipo' => 'detalle']),
            ],
            [
                'titulo' => 'Mensual resumen',
                'descripcion' => 'Resumen ejecutivo del mes seleccionado.',
                'icono' => 'fas fa-clipboard-list',
                'params' => array_merge($baseParams, ['reporte' => 'mensual', 'tipo' => 'resumen']),
            ],
            [
                'titulo' => 'Anual detallado',
                'descripcion' => 'Movimiento completo de enero a diciembre.',
                'icono' => 'fas fa-chart-line',
                'params' => array_merge($baseParams, ['reporte' => 'anual', 'tipo' => 'detalle']),
            ],
            [
                'titulo' => 'Anual resumen',
                'descripcion' => 'Vista consolidada para gerencia y toma de decisiones.',
                'icono' => 'fas fa-file-medical-alt',
                'params' => array_merge($baseParams, ['reporte' => 'anual', 'tipo' => 'resumen']),
            ],
        ];
    @endphp

    <div class="decision-hero mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2>Panorama de atenciones médicas</h2>
                <p class="mb-0">
                    Vista ejecutiva para analizar producción, comportamiento mensual, carga diaria,
                    conceptos más utilizados y rendimiento por médico.
                </p>
            </div>

            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                <div class="h5 mb-1">{{ $resumenMedico }}</div>
                <small class="d-block opacity-75">Periodo evaluado</small>
                <strong>{{ $mesNombre }} {{ $anio }}</strong>
            </div>
        </div>
    </div>

    <div class="card filter-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard') }}">
                <div class="row">
                    <div class="col-md-2">
                        <label>Año</label>
                        <input type="number" name="anio" class="form-control" value="{{ $anio }}" min="2000"
                            max="2100">
                    </div>

                    <div class="col-md-2">
                        <label>Mes</label>
                        <select name="mes" class="form-control">
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

                    <div class="col-md-2">
                        <label>Meta mensual</label>
                        <input type="number" name="meta_mensual" class="form-control" value="{{ $metaMensual }}"
                            min="0" placeholder="Opcional">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary btn-block btn-rounded">
                            <i class="fas fa-search"></i> Consultar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="metric-card">
                <div class="metric-icon icon-blue">
                    <i class="fas fa-notes-medical"></i>
                </div>
                <div class="metric-label">Atenciones del mes</div>
                <div class="metric-value">{{ $fmt($totalMes) }}</div>
                <div class="metric-foot">
                    @if (!is_null($variacionMes))
                        <span class="{{ $variacionMes >= 0 ? 'text-success' : 'text-danger' }}">
                            <i class="fas {{ $variacionMes >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            {{ abs($fmtDecimal($variacionMes)) }}%
                        </span>
                        vs mes anterior
                    @else
                        Sin base anterior
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="metric-card">
                <div class="metric-icon icon-green">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="metric-label">Atenciones del año</div>
                <div class="metric-value">{{ $fmt($totalAnio) }}</div>
                <div class="metric-foot">
                    Promedio mensual: {{ $fmtDecimal($promedioMensual) }}
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="metric-card">
                <div class="metric-icon icon-orange">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="metric-label">Promedio diario</div>
                <div class="metric-value">{{ $fmtDecimal($promedioDia) }}</div>
                <div class="metric-foot">
                    {{ $diasDelMes }} días en {{ strtolower($mesNombre) }}
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="metric-card">
                <div class="metric-icon icon-red">
                    <i class="fas fa-stethoscope"></i>
                </div>
                <div class="metric-label">Concepto líder</div>
                <div class="metric-value">{{ $topConceptoCodigo }}</div>
                <div class="metric-foot">
                    {{ $fmt($topConceptoTotal) }} atenciones · {{ $fmtDecimal($participacionTopConcepto) }}%
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="metric-card">
                <div class="metric-icon icon-purple">
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="metric-label">Médico líder</div>
                <div class="metric-value" style="font-size: 19px;">
                    {{ \Illuminate\Support\Str::limit($topMedicoNombre, 18) }}
                </div>
                <div class="metric-foot">
                    {{ $fmt($topMedicoTotal) }} atenciones · {{ $fmtDecimal($participacionTopMedico) }}%
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="metric-card">
                <div class="metric-icon icon-cyan">
                    <i class="fas fa-bullseye"></i>
                </div>
                <div class="metric-label">Proyección anual</div>
                <div class="metric-value">{{ $fmt($proyeccionAnual) }}</div>
                <div class="metric-foot">
                    @if (!is_null($cumplimientoMeta))
                        Meta mensual: {{ $fmtDecimal($cumplimientoMeta) }}%
                    @else
                        Basado en meses con movimiento
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (!is_null($cumplimientoMeta))
        <div class="card decision-card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong>
                        <i class="fas fa-bullseye text-primary mr-1"></i>
                        Cumplimiento de meta mensual
                    </strong>
                    <span class="font-weight-bold">{{ $fmtDecimal($cumplimientoMeta) }}%</span>
                </div>

                <div class="progress progress-thin">
                    <div class="progress-bar {{ $cumplimientoMeta >= 100 ? 'bg-success' : 'bg-primary' }}"
                        role="progressbar" style="width: {{ min($cumplimientoMeta, 100) }}%">
                    </div>
                </div>

                <small class="text-muted">
                    Meta: {{ $fmt($metaMensual) }} atenciones · Actual: {{ $fmt($totalMes) }} atenciones
                </small>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card decision-card">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title font-weight-bold mb-0">Tendencia mensual</h3>
                            <small class="text-muted">Comportamiento del año {{ $anio }}</small>
                        </div>
                        <i class="fas fa-chart-area text-primary"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-box">
                        <canvas id="chartMeses"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card decision-card">
                <div class="card-header bg-white border-0">
                    <h3 class="card-title font-weight-bold mb-0">Lectura ejecutiva</h3>
                </div>
                <div class="card-body">
                    <ul class="decision-list">
                        @foreach ($lecturaEjecutiva as $lectura)
                            <li>
                                <i class="fas fa-check-circle"></i>
                                <span>{{ $lectura }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card decision-card mt-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="metric-icon icon-green mb-0 mr-3">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <div class="metric-label">Mes más alto del año</div>
                            <strong>{{ $mejorMes['nombre'] ?? '-' }}</strong>
                            <div class="text-muted">{{ $fmt($mejorMes['total'] ?? 0) }} atenciones</div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex align-items-center">
                        <div class="metric-icon icon-orange mb-0 mr-3">
                            <i class="fas fa-fire"></i>
                        </div>
                        <div>
                            <div class="metric-label">Día de mayor carga</div>
                            <strong>Día {{ $mejorDia['dia'] ?? '-' }}</strong>
                            <div class="text-muted">{{ $fmt($mejorDia['total'] ?? 0) }} atenciones</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card decision-card">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title font-weight-bold mb-0">Actividad diaria del mes</h3>
                            <small class="text-muted">Carga operativa diaria de {{ $mesNombre }}</small>
                        </div>
                        <i class="fas fa-calendar-day text-primary"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-box">
                        <canvas id="chartDias"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card decision-card">
                <div class="card-header bg-white border-0">
                    <h3 class="card-title font-weight-bold mb-0">Top conceptos</h3>
                    <small class="text-muted">Conceptos con mayor movimiento</small>
                </div>
                <div class="card-body">
                    <div class="chart-box-sm">
                        <canvas id="chartConceptos"></canvas>
                    </div>

                    <hr>

                    <strong>{{ $topConceptoNombre }}</strong>
                    <div class="text-muted">
                        Código/orden: {{ $topConceptoCodigo }} · {{ $fmt($topConceptoTotal) }} atenciones
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
       

        <div class="col-lg-4 mb-4">
            <div class="card decision-card">
                <div class="card-header bg-white border-0">
                    <h3 class="card-title font-weight-bold mb-0">Top médicos</h3>
                    <small class="text-muted">Ranking del mes seleccionado</small>
                </div>
                <div class="card-body">
                    <div class="chart-box-sm">
                        <canvas id="chartMedicos"></canvas>
                    </div>

                    <hr>

                    <strong>{{ $topMedicoNombre }}</strong>
                    <div class="text-muted">
                        {{ $fmt($topMedicoTotal) }} atenciones registradas
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const mesesLabels = @json($chartMesesLabels);
        const datosMeses = @json($chartMesesData);

        const diasLabels = @json($chartDiasLabels);
        const datosDias = @json($chartDiasData);

        const conceptosLabels = @json($chartConceptosLabels);
        const conceptosData = @json($chartConceptosData);

        const medicosLabels = @json($chartMedicosLabels);
        const medicosData = @json($chartMedicosData);

        Chart.defaults.font.family =
            "'Source Sans Pro', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif";
        Chart.defaults.color = '#475569';

        const gridColor = 'rgba(148, 163, 184, .22)';

        function formatoNumero(valor) {
            return new Intl.NumberFormat('es-HN').format(valor);
        }

        function crearGradiente(ctx, colorInicio, colorFinal) {
            const gradient = ctx.createLinearGradient(0, 0, 0, 330);
            gradient.addColorStop(0, colorInicio);
            gradient.addColorStop(1, colorFinal);
            return gradient;
        }

        const canvasMeses = document.getElementById('chartMeses');
        const ctxMeses = canvasMeses.getContext('2d');

        new Chart(canvasMeses, {
            type: 'line',
            data: {
                labels: mesesLabels,
                datasets: [{
                    label: 'Atenciones',
                    data: datosMeses,
                    borderColor: '#2563eb',
                    backgroundColor: crearGradiente(ctxMeses, 'rgba(37, 99, 235, .28)',
                        'rgba(37, 99, 235, .02)'),
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.38,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Atenciones: ' + formatoNumero(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            callback: function(value) {
                                return formatoNumero(value);
                            }
                        },
                        grid: {
                            color: gridColor
                        }
                    }
                }
            }
        });

        const canvasDias = document.getElementById('chartDias');

        new Chart(canvasDias, {
            type: 'bar',
            data: {
                labels: diasLabels,
                datasets: [{
                    label: 'Atenciones por día',
                    data: datosDias,
                    backgroundColor: 'rgba(14, 116, 144, .72)',
                    borderColor: '#0e7490',
                    borderWidth: 1,
                    borderRadius: 8,
                    maxBarThickness: 24
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Atenciones: ' + formatoNumero(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            callback: function(value) {
                                return formatoNumero(value);
                            }
                        },
                        grid: {
                            color: gridColor
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('chartConceptos'), {
            type: 'bar',
            data: {
                labels: conceptosLabels,
                datasets: [{
                    label: 'Total',
                    data: conceptosData,
                    backgroundColor: 'rgba(37, 99, 235, .72)',
                    borderColor: '#2563eb',
                    borderWidth: 1,
                    borderRadius: 8,
                    maxBarThickness: 22
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Total: ' + formatoNumero(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            callback: function(value) {
                                return formatoNumero(value);
                            }
                        },
                        grid: {
                            color: gridColor
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('chartMedicos'), {
            type: 'doughnut',
            data: {
                labels: medicosLabels,
                datasets: [{
                    label: 'Total',
                    data: medicosData,
                    backgroundColor: [
                        '#2563eb',
                        '#16a34a',
                        '#f97316',
                        '#dc2626',
                        '#7c3aed',
                        '#0891b2',
                        '#ca8a04',
                        '#475569'
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + formatoNumero(context.raw);
                            }
                        }
                    }
                }
            }
        });
    </script>
@stop
