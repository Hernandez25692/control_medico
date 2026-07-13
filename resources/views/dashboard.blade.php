@extends('adminlte::page')

@section('title', 'Centro de Decisiones')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="mb-0 font-weight-bold">
                Centro de Decisiones
            </h1>

            <small class="text-muted">
                Indicadores reales de pacientes, productividad médica,
                cobertura operativa y calidad del registro.
            </small>
        </div>

        <div class="mt-2 mt-md-0 d-flex align-items-center flex-wrap" style="gap: 8px;">
            <span class="live-pill">
                <span class="live-dot"></span>
                Datos en vivo
            </span>

            <span class="badge badge-primary p-2">
                <i class="fas fa-calendar-alt mr-1"></i>
                {{ $meses[$mes] ?? $mes }} {{ $anio }}
            </span>
        </div>
    </div>
@stop

@section('css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --navy: #0B3B5C;
            --navy-dark: #082A44;
            --navy-deeper: #051D30;
            --teal: #1E8A75;
            --teal-light: #2FB39A;
            --teal-tint: #E4F5F1;
            --amber: #B9821E;
            --amber-tint: #FFF6E0;
            --gold: #A67C1E;
            --gold-tint: #FBF3DC;
            --coral: #B3434B;
            --coral-tint: #FBE7E8;
            --plum: #6D4AA6;
            --plum-tint: #EEE7F7;
            --sky: #1C7FA0;
            --sky-tint: #E1F1F6;
            --navy-tint: #E5EDF3;

            --dashboard-primary: var(--teal);
            --dashboard-dark: #16232E;
            --dashboard-muted: #64748b;
            --dashboard-border: #E2E8ED;
            --dashboard-background: #F5F8FA;
        }

        .content-wrapper {
            background: var(--dashboard-background);
        }

        body,
        .card,
        .btn,
        .form-control,
        .badge,
        .status-badge {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        .card-title {
            font-family: 'Space Grotesk', sans-serif;
        }

        .decision-hero {
            position: relative;
            overflow: hidden;
            padding: 28px 25px;
            color: #ffffff;
            border-radius: 20px;
            background: linear-gradient(135deg,
                    var(--navy-deeper) 0%,
                    var(--navy-dark) 48%,
                    var(--navy) 100%);
            background-size: 180% 180%;
            box-shadow: 0 18px 40px rgba(5, 29, 48, .32);
            animation: heroDrift 14s ease-in-out infinite, fadeInUp .5s ease both;
        }

        @keyframes heroDrift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .decision-hero::before,
        .decision-hero::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(47, 179, 154, .14);
            animation: floatSlow 8s ease-in-out infinite;
        }

        .decision-hero::before {
            width: 230px;
            height: 230px;
            top: -110px;
            right: -60px;
        }

        .decision-hero::after {
            width: 140px;
            height: 140px;
            right: 100px;
            bottom: -90px;
            background: rgba(255, 255, 255, .06);
            animation-delay: -3s;
        }

        @keyframes floatSlow {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-12px) scale(1.05);
            }
        }

        .hero-ekg {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 18px;
            width: 100%;
            height: 46px;
            z-index: 0;
            opacity: .35;
            pointer-events: none;
        }

        .hero-ekg path {
            fill: none;
            stroke: var(--teal-light);
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            filter: drop-shadow(0 0 5px rgba(47, 179, 154, .5));
        }

        .decision-hero .row {
            position: relative;
            z-index: 1;
        }

        .decision-hero h2 {
            margin-bottom: 5px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.01em;
        }

        .decision-hero p {
            max-width: 920px;
            opacity: .88;
        }

        /* ---------- Badge "en vivo" ---------- */

        .live-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 12px;
            border-radius: 999px;
            background: var(--teal-tint);
            color: #146455;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        .live-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--teal);
            animation: pulseDot 2s ease-in-out infinite;
        }

        @keyframes pulseDot {
            0% {
                box-shadow: 0 0 0 0 rgba(30, 138, 117, .5);
            }

            70% {
                box-shadow: 0 0 0 6px rgba(30, 138, 117, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(30, 138, 117, 0);
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .decision-hero,
            .decision-hero::before,
            .decision-hero::after,
            .live-dot,
            .metric-card,
            .decision-card {
                animation: none !important;
            }
        }

        .filter-card,
        .metric-card,
        .decision-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(11, 59, 92, .07);
        }

        .decision-card {
            transition: box-shadow .25s ease, transform .25s ease;
            animation: fadeInUp .5s ease both;
        }

        .decision-card:hover {
            box-shadow: 0 16px 34px rgba(11, 59, 92, .12);
        }

        .decision-card .card-header {
            position: relative;
        }

        .decision-card .card-header i.fas {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            font-size: 15px;
            background: var(--teal-tint);
            color: var(--teal) !important;
        }

        .filter-card .card-body {
            padding: 20px;
        }

        .filter-card label {
            color: var(--dashboard-dark);
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            font-family: 'IBM Plex Mono', monospace;
        }

        .filter-card .form-control {
            height: 42px;
            border-color: var(--dashboard-border);
            border-radius: 10px;
            font-size: 13.5px;
        }

        .filter-card .form-control:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(30, 138, 117, .12);
        }

        .btn-rounded {
            height: 42px;
            border-radius: 10px;
            font-weight: 700;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--teal) 0%, #17705F 100%);
            border: none;
            box-shadow: 0 10px 20px -8px rgba(30, 138, 117, .5);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: linear-gradient(135deg, #1c7c69 0%, #146253 100%);
        }

        .metric-card {
            position: relative;
            min-height: 164px;
            padding: 18px;
            overflow: hidden;
            background: #ffffff;
            border-top: 3px solid transparent;
            transition: transform .22s cubic-bezier(.2, .8, .3, 1), box-shadow .22s ease, border-color .22s ease;
            animation: fadeInUp .45s ease both;
        }

        .row>div:nth-child(1) .metric-card {
            animation-delay: .02s;
        }

        .row>div:nth-child(2) .metric-card {
            animation-delay: .06s;
        }

        .row>div:nth-child(3) .metric-card {
            animation-delay: .10s;
        }

        .row>div:nth-child(4) .metric-card {
            animation-delay: .14s;
        }

        .row>div:nth-child(5) .metric-card {
            animation-delay: .18s;
        }

        .row>div:nth-child(6) .metric-card {
            animation-delay: .22s;
        }

        .row>div:nth-child(7) .metric-card {
            animation-delay: .26s;
        }

        .row>div:nth-child(8) .metric-card {
            animation-delay: .30s;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 32px rgba(11, 59, 92, .16);
            border-top-color: var(--teal);
        }

        .metric-card:hover .metric-icon {
            transform: scale(1.08) rotate(-4deg);
        }

        .metric-card::after {
            content: "";
            position: absolute;
            width: 90px;
            height: 90px;
            right: -38px;
            bottom: -38px;
            border-radius: 50%;
            background: rgba(11, 59, 92, .04);
        }

        .metric-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            margin-bottom: 13px;
            border-radius: 14px;
            font-size: 20px;
            position: relative;
            box-shadow: inset 0 0 0 1px rgba(0, 0, 0, .04);
            transition: transform .25s cubic-bezier(.2, .8, .3, 1);
        }

        .metric-icon::before {
            content: "";
            position: absolute;
            inset: -5px;
            border-radius: 16px;
            border: 1px solid currentColor;
            opacity: .16;
        }

        .metric-label {
            color: var(--dashboard-muted);
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            font-family: 'IBM Plex Mono', monospace;
        }

        .metric-value {
            margin-top: 5px;
            color: var(--dashboard-dark);
            font-size: 28px;
            font-weight: 700;
            line-height: 1.1;
            font-family: 'Space Grotesk', sans-serif;
        }

        .metric-value-name {
            min-height: 33px;
            font-size: 17px;
            line-height: 1.2;
        }

        .metric-foot {
            position: relative;
            z-index: 2;
            margin-top: 9px;
            color: var(--dashboard-muted);
            font-size: 12.5px;
        }

        /* ---------- Paleta de iconos coordinada con la marca ---------- */

        .icon-blue {
            color: var(--navy);
            background: var(--navy-tint);
        }

        .icon-green {
            color: var(--teal);
            background: var(--teal-tint);
        }

        .icon-orange {
            color: var(--amber);
            background: var(--amber-tint);
        }

        .icon-red {
            color: var(--coral);
            background: var(--coral-tint);
        }

        .icon-purple {
            color: var(--plum);
            background: var(--plum-tint);
        }

        .icon-cyan {
            color: var(--sky);
            background: var(--sky-tint);
        }

        .icon-yellow {
            color: var(--gold);
            background: var(--gold-tint);
        }

        .icon-teal {
            color: #146455;
            background: #D9F0EA;
        }

        .decision-card .card-header {
            padding: 18px 20px 8px;
            border: 0;
            background: #ffffff;
        }

        .decision-card .card-header .card-title {
            font-weight: 700;
        }

        .decision-card .card-body {
            padding: 18px 20px 20px;
        }

        .chart-box {
            position: relative;
            height: 340px;
        }

        .chart-box-sm {
            position: relative;
            height: 315px;
        }

        .decision-list {
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
        }

        .decision-list li {
            display: flex;
            gap: 10px;
            padding: 12px 0;
            border-bottom: 1px solid var(--dashboard-border);
            color: #334155;
            font-size: 13.5px;
        }

        .decision-list li:last-child {
            border-bottom: 0;
        }

        .decision-list i {
            margin-top: 3px;
            color: var(--teal);
        }

        .quality-alert {
            height: 100%;
            margin-bottom: 0;
            border: 0;
            border-radius: 14px;
            box-shadow: 0 7px 18px rgba(11, 59, 92, .06);
        }

        .alert-warning.quality-alert {
            background: var(--amber-tint);
            color: #7a5a10;
            border-left: 4px solid var(--amber);
        }

        .indicator-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 0;
            border-bottom: 1px solid var(--dashboard-border);
        }

        .indicator-row:last-child {
            border-bottom: 0;
        }

        .indicator-title {
            color: #475569;
            font-size: 13px;
        }

        .indicator-value {
            color: var(--dashboard-dark);
            font-size: 17px;
            font-weight: 700;
            font-family: 'Space Grotesk', sans-serif;
        }

        .progress-thin {
            height: 9px;
            border-radius: 999px;
            background: var(--dashboard-border);
        }

        .progress-thin .progress-bar {
            border-radius: 999px;
        }

        .progress-thin .progress-bar.bg-primary {
            background: var(--teal) !important;
        }

        .progress-thin .progress-bar.bg-success {
            background: var(--teal-light) !important;
        }

        .progress-thin .progress-bar {
            position: relative;
            overflow: hidden;
            transition: width 1s cubic-bezier(.2, .8, .3, 1);
        }

        .progress-thin .progress-bar::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, .35),
                    transparent);
            animation: shimmer 2.2s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .health-stat {
            padding: 15px;
            border: 1px solid var(--dashboard-border);
            border-radius: 13px;
            background: #ffffff;
        }

        .health-stat-title {
            color: var(--dashboard-muted);
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            font-family: 'IBM Plex Mono', monospace;
        }

        .health-stat-value {
            margin-top: 5px;
            color: var(--dashboard-dark);
            font-size: 23px;
            font-weight: 700;
            font-family: 'Space Grotesk', sans-serif;
        }

        .health-stat-foot {
            margin-top: 4px;
            color: var(--dashboard-muted);
            font-size: 12px;
        }

        .badge-soft-success {
            color: #146455;
            background: var(--teal-tint);
        }

        .badge-soft-warning {
            color: #7a5a10;
            background: var(--amber-tint);
        }

        .badge-soft-danger {
            color: #7a2b30;
            background: var(--coral-tint);
        }

        .badge-soft-primary {
            color: var(--navy);
            background: var(--navy-tint);
        }

        .status-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-primary {
            background: var(--navy) !important;
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            letter-spacing: 0.03em;
            border-radius: 999px;
            padding: 7px 12px !important;
        }

        .text-success {
            color: var(--teal) !important;
        }

        .text-danger {
            color: var(--coral) !important;
        }

        .text-primary {
            color: var(--navy) !important;
        }

        @media (max-width: 767px) {
            .decision-hero {
                padding: 19px;
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
        /*
        |--------------------------------------------------------------------------
        | Valores seguros
        |--------------------------------------------------------------------------
        | Los valores por defecto evitan errores visuales mientras se integra
        | completamente el servicio de estadísticas.
        */

        $fmt = fn($numero) => number_format((float) $numero, 0, '.', ',');
        $fmtDecimal = fn($numero) => number_format((float) $numero, 1, '.', ',');

        $mesNombre = $meses[$mes] ?? $mes;

        $totalMes = $totalMes ?? 0;
        $totalAnio = $totalAnio ?? 0;
        $promedioDia = $promedioDia ?? 0;

        $diasDelMes = $diasDelMes ?? 0;
        $diasLaborablesMes = $diasLaborablesMes ?? 0;
        $diasLaborablesEvaluados = $diasLaborablesEvaluados ?? 0;
        $diasConAtencion = $diasConAtencion ?? 0;
        $diasSinRegistro = $diasSinRegistro ?? 0;

        $coberturaRegistro = $coberturaRegistro ?? 0;
        $promedioPorDiaConActividad = $promedioPorDiaConActividad ?? 0;
        $proyeccionMensual = $proyeccionMensual ?? 0;
        $registrosFinSemana = $registrosFinSemana ?? 0;
        $totalMenoresCinco = $totalMenoresCinco ?? 0;

        $promedioMensual = $promedioMensual ?? 0;
        $proyeccionAnual = $proyeccionAnual ?? 0;

        $variacionMes = $variacionMes ?? null;
        $cumplimientoMeta = $cumplimientoMeta ?? null;

        $topConceptoNombre = $topConceptoNombre ?? 'Sin datos';
        $topConceptoCodigo = $topConceptoCodigo ?? '-';
        $topConceptoTotal = $topConceptoTotal ?? 0;
        $participacionTopConcepto = $participacionTopConcepto ?? 0;

        $topMedicoNombre = $topMedicoNombre ?? 'Sin datos';
        $topMedicoTotal = $topMedicoTotal ?? 0;
        $participacionTopMedico = $participacionTopMedico ?? 0;

        $mejorDia = $mejorDia ?? ['dia' => '-', 'total' => 0];
        $mejorMes = $mejorMes ?? ['nombre' => '-', 'total' => 0];

        $lecturaEjecutiva = $lecturaEjecutiva ?? [];
        $resumenMedico = $resumenMedico ?? 'Todos los médicos';

        $porcentajeMenoresCinco = $totalMes > 0 ? round(($totalMenoresCinco / $totalMes) * 100, 1) : 0;

        $productividadEsperada = $diasLaborablesMes > 0 ? round($proyeccionMensual / $diasLaborablesMes, 1) : 0;

        $faltanteMeta = $metaMensual && $metaMensual > $totalMes ? $metaMensual - $totalMes : 0;

        $estadoCobertura = match (true) {
            $coberturaRegistro >= 95 => [
                'texto' => 'Óptima',
                'clase' => 'badge-soft-success',
            ],
            $coberturaRegistro >= 80 => [
                'texto' => 'Aceptable',
                'clase' => 'badge-soft-warning',
            ],
            default => [
                'texto' => 'Requiere revisión',
                'clase' => 'badge-soft-danger',
            ],
        };

        $estadoVariacion = match (true) {
            is_null($variacionMes) => [
                'texto' => 'Sin comparación',
                'clase' => 'text-muted',
                'icono' => 'fa-minus',
            ],
            $variacionMes > 0 => [
                'texto' => 'Incremento',
                'clase' => 'text-success',
                'icono' => 'fa-arrow-up',
            ],
            $variacionMes < 0 => [
                'texto' => 'Disminución',
                'clase' => 'text-danger',
                'icono' => 'fa-arrow-down',
            ],
            default => [
                'texto' => 'Sin cambio',
                'clase' => 'text-muted',
                'icono' => 'fa-equals',
            ],
        };
    @endphp

    {{-- ================================================================
        ENCABEZADO EJECUTIVO
    ================================================================= --}}

    <div class="decision-hero mb-4">
        <svg class="hero-ekg" viewBox="0 0 900 90" preserveAspectRatio="none" aria-hidden="true">
            <path
                d="M0,45 L260,45 L278,45 L290,15 L305,78 L320,30 L335,45 L520,45 L538,45 L550,15 L565,78 L580,30 L595,45 L900,45" />
        </svg>

        <div class="row align-items-center">
            <div class="col-md-8">
                <h2>Panorama de pacientes atendidos</h2>

                <p class="mb-0">
                    Análisis basado en el indicador oficial
                    <strong>Total de Pacientes Atendidos</strong>,
                    considerando únicamente días laborables de lunes a viernes.
                </p>
            </div>

            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                <div class="h5 mb-1">
                    {{ $resumenMedico }}
                </div>

                <small class="d-block">
                    Periodo evaluado
                </small>

                <strong>
                    {{ $mesNombre }} {{ $anio }}
                </strong>
            </div>
        </div>
    </div>

    {{-- ================================================================
        FILTROS
    ================================================================= --}}

    <div class="card filter-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard') }}">
                <div class="row">

                    <div class="col-md-2 mb-3 mb-md-0">
                        <label for="anio">
                            Año
                        </label>

                        <input type="number" id="anio" name="anio" class="form-control" value="{{ $anio }}"
                            min="2000" max="2100" required>
                    </div>

                    <div class="col-md-2 mb-3 mb-md-0">
                        <label for="mes">
                            Mes
                        </label>

                        <select id="mes" name="mes" class="form-control" required>
                            @foreach ($meses as $numero => $nombre)
                                <option value="{{ $numero }}" {{ (int) $mes === (int) $numero ? 'selected' : '' }}>
                                    {{ $nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3 mb-md-0">
                        <label for="medico_id">
                            Médico
                        </label>

                        <select id="medico_id" name="medico_id" class="form-control">
                            <option value="">
                                Todos los médicos
                            </option>

                            @foreach ($medicos as $medico)
                                <option value="{{ $medico->id }}"
                                    {{ (int) $medicoId === (int) $medico->id ? 'selected' : '' }}>
                                    {{ $medico->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 mb-3 mb-md-0">
                        <label for="meta_mensual">
                            Meta mensual
                        </label>

                        <input type="number" id="meta_mensual" name="meta_mensual" class="form-control"
                            value="{{ $metaMensual }}" min="0" placeholder="Opcional">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-block btn-rounded">
                            <i class="fas fa-search mr-1"></i>
                            Consultar
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- ================================================================
        INDICADORES PRINCIPALES
    ================================================================= --}}

    <div class="row">

        {{-- Pacientes del mes --}}
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="metric-card">
                <div class="metric-icon icon-blue">
                    <i class="fas fa-hospital-user"></i>
                </div>

                <div class="metric-label">
                    Pacientes atendidos del mes
                </div>

                <div class="metric-value">
                    {{ $fmt($totalMes) }}
                </div>

                <div class="metric-foot">
                    <strong>Fuente:</strong>
                    Total de Pacientes Atendidos
                </div>
            </div>
        </div>

        {{-- Pacientes del año --}}
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="metric-card">
                <div class="metric-icon icon-green">
                    <i class="fas fa-chart-line"></i>
                </div>

                <div class="metric-label">
                    Pacientes atendidos del año
                </div>

                <div class="metric-value">
                    {{ $fmt($totalAnio) }}
                </div>

                <div class="metric-foot">
                    Promedio mensual:
                    <strong>{{ $fmtDecimal($promedioMensual) }}</strong>
                </div>
            </div>
        </div>

        {{-- Promedio laborable --}}
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="metric-card">
                <div class="metric-icon icon-orange">
                    <i class="fas fa-calendar-day"></i>
                </div>

                <div class="metric-label">
                    Promedio por día laborable
                </div>

                <div class="metric-value">
                    {{ $fmtDecimal($promedioDia) }}
                </div>

                <div class="metric-foot">
                    {{ $diasLaborablesEvaluados }}
                    días laborables evaluados
                </div>
            </div>
        </div>

        {{-- Cobertura --}}
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="metric-card">
                <div class="metric-icon icon-purple">
                    <i class="fas fa-calendar-check"></i>
                </div>

                <div class="metric-label">
                    Cobertura del registro
                </div>

                <div class="metric-value">
                    {{ $fmtDecimal($coberturaRegistro) }}%
                </div>

                <div class="metric-foot">
                    {{ $diasConAtencion }}
                    de
                    {{ $diasLaborablesEvaluados }}
                    días evaluados

                    <span class="status-badge {{ $estadoCobertura['clase'] }} ml-1">
                        {{ $estadoCobertura['texto'] }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Proyección mensual --}}
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="metric-card">
                <div class="metric-icon icon-cyan">
                    <i class="fas fa-bullseye"></i>
                </div>

                <div class="metric-label">
                    Proyección al cierre del mes
                </div>

                <div class="metric-value">
                    {{ $fmt($proyeccionMensual) }}
                </div>

                <div class="metric-foot">
                    Proyección para
                    {{ $diasLaborablesMes }}
                    días laborables
                </div>
            </div>
        </div>

        {{-- Menores de cinco años --}}
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="metric-card">
                <div class="metric-icon icon-teal">
                    <i class="fas fa-child"></i>
                </div>

                <div class="metric-label">
                    Menores de cinco años
                </div>

                <div class="metric-value">
                    {{ $fmt($totalMenoresCinco) }}
                </div>

                <div class="metric-foot">
                    {{ $fmtDecimal($porcentajeMenoresCinco) }}%
                    del total mensual
                </div>
            </div>
        </div>

        {{-- Médico líder --}}
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="metric-card">
                <div class="metric-icon icon-red">
                    <i class="fas fa-user-md"></i>
                </div>

                <div class="metric-label">
                    Médico con mayor atención
                </div>

                <div class="metric-value metric-value-name">
                    {{ \Illuminate\Support\Str::limit($topMedicoNombre, 25) }}
                </div>

                <div class="metric-foot">
                    {{ $fmt($topMedicoTotal) }}
                    pacientes ·
                    {{ $fmtDecimal($participacionTopMedico) }}%
                    del total
                </div>
            </div>
        </div>

        {{-- Variación mensual --}}
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="metric-card">
                <div class="metric-icon icon-yellow">
                    <i class="fas fa-exchange-alt"></i>
                </div>

                <div class="metric-label">
                    Variación mensual
                </div>

                <div class="metric-value">
                    @if (!is_null($variacionMes))
                        {{ $variacionMes > 0 ? '+' : '' }}
                        {{ $fmtDecimal($variacionMes) }}%
                    @else
                        N/D
                    @endif
                </div>

                <div class="metric-foot {{ $estadoVariacion['clase'] }}">
                    <i class="fas {{ $estadoVariacion['icono'] }} mr-1"></i>
                    {{ $estadoVariacion['texto'] }}
                    respecto al mes anterior
                </div>
            </div>
        </div>

    </div>

    {{-- ================================================================
        ALERTAS DE CALIDAD DE DATOS
    ================================================================= --}}

    @if ($diasSinRegistro > 0 || $registrosFinSemana > 0)
        <div class="row mb-4">

            @if ($diasSinRegistro > 0)
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="alert alert-warning quality-alert">
                        <div class="d-flex">
                            <div class="mr-3">
                                <i class="fas fa-calendar-times fa-2x"></i>
                            </div>

                            <div>
                                <strong>
                                    Días laborables sin registro
                                </strong>

                                <div>
                                    Se identificaron
                                    <strong>{{ $diasSinRegistro }}</strong>
                                    días laborables sin pacientes atendidos.
                                </div>

                                <small>
                                    Debe validarse si corresponde a falta de atención,
                                    ausencia del médico o registro pendiente.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @endif



        </div>
    @endif

    {{-- ================================================================
        CUMPLIMIENTO DE META
    ================================================================= --}}

    @if (!is_null($cumplimientoMeta))
        <div class="card decision-card mb-4">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong>
                        <i class="fas fa-bullseye text-primary mr-1"></i>
                        Cumplimiento de meta mensual
                    </strong>

                    <span class="font-weight-bold">
                        {{ $fmtDecimal($cumplimientoMeta) }}%
                    </span>
                </div>

                <div class="progress progress-thin">
                    <div class="progress-bar {{ $cumplimientoMeta >= 100 ? 'bg-success' : 'bg-primary' }}"
                        role="progressbar" style="width: {{ min($cumplimientoMeta, 100) }}%"
                        aria-valuenow="{{ min($cumplimientoMeta, 100) }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="d-flex justify-content-between flex-wrap mt-2">
                    <small class="text-muted">
                        Meta:
                        <strong>{{ $fmt($metaMensual) }}</strong>
                        pacientes
                    </small>

                    <small class="text-muted">
                        Actual:
                        <strong>{{ $fmt($totalMes) }}</strong>
                        pacientes
                    </small>

                    @if ($faltanteMeta > 0)
                        <small class="text-danger">
                            Faltan:
                            <strong>{{ $fmt($faltanteMeta) }}</strong>
                            pacientes
                        </small>
                    @else
                        <small class="text-success">
                            <strong>Meta alcanzada</strong>
                        </small>
                    @endif
                </div>

            </div>
        </div>
    @endif

    {{-- ================================================================
        TENDENCIA ANUAL Y LECTURA EJECUTIVA
    ================================================================= --}}

    <div class="row">

        <div class="col-lg-8 mb-4">
            <div class="card decision-card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title font-weight-bold mb-0">
                                Tendencia anual de pacientes
                            </h3>

                            <small class="text-muted">
                                Total mensual del indicador oficial durante {{ $anio }}
                            </small>
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
                <div class="card-header">
                    <h3 class="card-title font-weight-bold mb-0">
                        Lectura ejecutiva
                    </h3>
                </div>

                <div class="card-body">
                    @if (count($lecturaEjecutiva) > 0)
                        <ul class="decision-list">
                            @foreach ($lecturaEjecutiva as $lectura)
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <span>{{ $lectura }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>

                            <div>
                                No existen observaciones para el periodo.
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card decision-card mt-4">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold mb-0">
                        Hitos del periodo
                    </h3>
                </div>

                <div class="card-body">

                    <div class="indicator-row">
                        <div>
                            <div class="indicator-title">
                                Mes de mayor atención
                            </div>

                            <strong>
                                {{ $mejorMes['nombre'] ?? '-' }}
                            </strong>
                        </div>

                        <div class="indicator-value">
                            {{ $fmt($mejorMes['total'] ?? 0) }}
                        </div>
                    </div>

                    <div class="indicator-row">
                        <div>
                            <div class="indicator-title">
                                Día laborable de mayor carga
                            </div>

                            <strong>
                                Día {{ $mejorDia['dia'] ?? '-' }}
                            </strong>
                        </div>

                        <div class="indicator-value">
                            {{ $fmt($mejorDia['total'] ?? 0) }}
                        </div>
                    </div>

                    <div class="indicator-row">
                        <div>
                            <div class="indicator-title">
                                Promedio en días con actividad
                            </div>

                            <strong>
                                Pacientes por jornada activa
                            </strong>
                        </div>

                        <div class="indicator-value">
                            {{ $fmtDecimal($promedioPorDiaConActividad) }}
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

    {{-- ================================================================
        INDICADORES DE SALUD Y OPERACIÓN
    ================================================================= --}}

    <div class="card decision-card mb-4">
        <div class="card-header">
            <div>
                <h3 class="card-title font-weight-bold mb-0">
                    Indicadores operativos y de atención
                </h3>

                <small class="text-muted">
                    Resumen mensual para seguimiento de productividad y cobertura
                </small>
            </div>
        </div>

        <div class="card-body">
            <div class="row">

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="health-stat">
                        <div class="health-stat-title">
                            Días laborables del mes
                        </div>

                        <div class="health-stat-value">
                            {{ $diasLaborablesMes }}
                        </div>

                        <div class="health-stat-foot">
                            Jornada institucional estimada
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="health-stat">
                        <div class="health-stat-title">
                            Días con atención
                        </div>

                        <div class="health-stat-value">
                            {{ $diasConAtencion }}
                        </div>

                        <div class="health-stat-foot">
                            Días con pacientes mayores que cero
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="health-stat">
                        <div class="health-stat-title">
                            Productividad proyectada
                        </div>

                        <div class="health-stat-value">
                            {{ $fmtDecimal($productividadEsperada) }}
                        </div>

                        <div class="health-stat-foot">
                            Pacientes por día laborable
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="health-stat">
                        <div class="health-stat-title">
                            Participación menores de 5
                        </div>

                        <div class="health-stat-value">
                            {{ $fmtDecimal($porcentajeMenoresCinco) }}%
                        </div>

                        <div class="health-stat-foot">
                            Sobre pacientes atendidos del mes
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ================================================================
        ACTIVIDAD DIARIA Y TOP CONCEPTOS
    ================================================================= --}}

    <div class="row">

        <div class="col-lg-8 mb-4">
            <div class="card decision-card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title font-weight-bold mb-0">
                                Pacientes por día laborable
                            </h3>

                            <small class="text-muted">
                                Actividad diaria de {{ $mesNombre }}.
                                Sábados y domingos no se incluyen.
                            </small>
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
            <div class="card decision-card h-100">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold mb-0">
                        Principales servicios registrados
                    </h3>

                    <small class="text-muted">
                        Excluye las filas automáticas 19 y 44
                    </small>
                </div>

                <div class="card-body">
                    <div class="chart-box-sm">
                        <canvas id="chartConceptos"></canvas>
                    </div>

                    <hr>

                    <div>
                        <span class="status-badge badge-soft-primary">
                            Principal concepto
                        </span>
                    </div>

                    <strong class="d-block mt-2">
                        {{ $topConceptoNombre }}
                    </strong>

                    <div class="text-muted">
                        Orden:
                        {{ $topConceptoCodigo }}

                        ·

                        {{ $fmt($topConceptoTotal) }}
                        registros

                        ·

                        {{ $fmtDecimal($participacionTopConcepto) }}%
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ================================================================
        TOP MÉDICOS
    ================================================================= --}}

    <div class="row">

        <div class="col-lg-7 mb-4">
            <div class="card decision-card h-100">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold mb-0">
                        Distribución de pacientes por médico
                    </h3>

                    <small class="text-muted">
                        Calculado únicamente con Total de Pacientes Atendidos
                    </small>
                </div>

                <div class="card-body">
                    <div class="chart-box">
                        <canvas id="chartMedicos"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="card decision-card h-100">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold mb-0">
                        Resumen del médico líder
                    </h3>
                </div>

                <div class="card-body">

                    <div class="d-flex align-items-center mb-4">
                        <div class="metric-icon icon-purple mb-0 mr-3">
                            <i class="fas fa-user-md"></i>
                        </div>

                        <div>
                            <div class="metric-label">
                                Médico con mayor volumen
                            </div>

                            <strong class="d-block">
                                {{ $topMedicoNombre }}
                            </strong>

                            <span class="text-muted">
                                {{ $fmt($topMedicoTotal) }}
                                pacientes atendidos
                            </span>
                        </div>
                    </div>

                    <div class="indicator-row">
                        <div class="indicator-title">
                            Participación del total mensual
                        </div>

                        <div class="indicator-value">
                            {{ $fmtDecimal($participacionTopMedico) }}%
                        </div>
                    </div>

                    <div class="indicator-row">
                        <div class="indicator-title">
                            Total institucional del mes
                        </div>

                        <div class="indicator-value">
                            {{ $fmt($totalMes) }}
                        </div>
                    </div>

                    <div class="indicator-row">
                        <div class="indicator-title">
                            Diferencia frente al total institucional
                        </div>

                        <div class="indicator-value">
                            {{ $fmt(max(0, $totalMes - $topMedicoTotal)) }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mesesLabels = @json($chartMesesLabels ?? []);
            const datosMeses = @json($chartMesesData ?? []);

            const diasLabels = @json($chartDiasLabels ?? []);
            const datosDias = @json($chartDiasData ?? []);

            const conceptosLabels = @json($chartConceptosLabels ?? []);
            const conceptosData = @json($chartConceptosData ?? []);

            const medicosLabels = @json($chartMedicosLabels ?? []);
            const medicosData = @json($chartMedicosData ?? []);

            Chart.defaults.font.family =
                "'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif";

            Chart.defaults.color = '#5C6B78';

            const gridColor = 'rgba(11, 59, 92, .10)';

            function formatoNumero(valor) {
                return new Intl.NumberFormat('es-HN').format(valor || 0);
            }

            function crearGradiente(ctx, colorInicio, colorFinal) {
                const gradient = ctx.createLinearGradient(0, 0, 0, 330);

                gradient.addColorStop(0, colorInicio);
                gradient.addColorStop(1, colorFinal);

                return gradient;
            }

            /*
            |--------------------------------------------------------------------------
            | Tendencia anual
            |--------------------------------------------------------------------------
            */

            const canvasMeses = document.getElementById('chartMeses');

            if (canvasMeses) {
                const ctxMeses = canvasMeses.getContext('2d');

                new Chart(canvasMeses, {
                    type: 'line',

                    data: {
                        labels: mesesLabels,

                        datasets: [{
                            label: 'Pacientes atendidos',
                            data: datosMeses,
                            borderColor: '#1E8A75',
                            backgroundColor: crearGradiente(
                                ctxMeses,
                                'rgba(30, 138, 117, .30)',
                                'rgba(30, 138, 117, .02)'
                            ),
                            pointBackgroundColor: '#1E8A75',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            borderWidth: 3,
                            tension: .35,
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
                                        return 'Pacientes: ' +
                                            formatoNumero(context.raw);
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
            }

            /*
            |--------------------------------------------------------------------------
            | Actividad diaria
            |--------------------------------------------------------------------------
            */

            const canvasDias = document.getElementById('chartDias');

            if (canvasDias) {
                new Chart(canvasDias, {
                    type: 'bar',

                    data: {
                        labels: diasLabels,

                        datasets: [{
                            label: 'Pacientes por día',
                            data: datosDias,
                            backgroundColor: 'rgba(11, 59, 92, .78)',
                            borderColor: '#0B3B5C',
                            borderWidth: 1,
                            borderRadius: 7,
                            maxBarThickness: 26
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
                                    title: function(items) {
                                        return 'Día ' + items[0].label;
                                    },

                                    label: function(context) {
                                        return 'Pacientes: ' +
                                            formatoNumero(context.raw);
                                    }
                                }
                            }
                        },

                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Día laborable del mes'
                                },

                                grid: {
                                    display: false
                                }
                            },

                            y: {
                                beginAtZero: true,

                                title: {
                                    display: true,
                                    text: 'Pacientes'
                                },

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
            }

            /*
            |--------------------------------------------------------------------------
            | Top conceptos
            |--------------------------------------------------------------------------
            */

            const canvasConceptos = document.getElementById('chartConceptos');

            if (canvasConceptos) {
                new Chart(canvasConceptos, {
                    type: 'bar',

                    data: {
                        labels: conceptosLabels,

                        datasets: [{
                            label: 'Registros',
                            data: conceptosData,
                            backgroundColor: 'rgba(185, 130, 30, .75)',
                            borderColor: '#B9821E',
                            borderWidth: 1,
                            borderRadius: 7,
                            maxBarThickness: 23
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
                                        return 'Registros: ' +
                                            formatoNumero(context.raw);
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
                                },

                                ticks: {
                                    autoSkip: false,
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });
            }

            /*
            |--------------------------------------------------------------------------
            | Ranking de médicos
            |--------------------------------------------------------------------------
            */

            const canvasMedicos = document.getElementById('chartMedicos');

            if (canvasMedicos) {
                new Chart(canvasMedicos, {
                    type: 'bar',

                    data: {
                        labels: medicosLabels,

                        datasets: [{
                            label: 'Pacientes atendidos',
                            data: medicosData,
                            backgroundColor: 'rgba(109, 74, 166, .75)',
                            borderColor: '#6D4AA6',
                            borderWidth: 1,
                            borderRadius: 7,
                            maxBarThickness: 35
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
                                        return 'Pacientes: ' +
                                            formatoNumero(context.raw);
                                    }
                                }
                            }
                        },

                        scales: {
                            x: {
                                beginAtZero: true,

                                title: {
                                    display: true,
                                    text: 'Pacientes atendidos'
                                },

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
            }
        });
    </script>
@stop
