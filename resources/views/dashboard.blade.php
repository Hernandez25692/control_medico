@extends('adminlte::page')

@section('title', 'Medical Command Center')

@section('content_header')
    {{-- Se integra en el hero --}}
@stop

@section('css')
    {{-- Fuentes premium --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap"
        rel="stylesheet">

    <style>
        /* ================================================================
                                               VARIABLES DE MARCA
                                            ================================================================ */
        :root {
            --primary-dark: #0A2647;
            --primary-mid: #144272;
            --accent-teal: #0F9D8A;
            --accent-teal-light: #2DD4BF;
            --accent-gold: #C89B3C;
            --accent-coral: #D65A5A;
            --accent-plum: #7B5EA7;
            --accent-sky: #3B8FC2;
            --surface-bg: #F4F8FA;
            --card-bg: rgba(255, 255, 255, 0.96);
            --card-border: rgba(200, 215, 225, 0.6);
            --text-dark: #1A2E3F;
            --text-muted: #6B7F8D;
            --shadow-sm: 0 8px 24px rgba(10, 38, 71, 0.07);
            --shadow-md: 0 16px 40px rgba(10, 38, 71, 0.10);
            --shadow-lg: 0 24px 60px rgba(10, 38, 71, 0.15);
            --radius-card: 20px;
            --radius-sm: 12px;
        }

        /* ================================================================
                                               ESTILOS GLOBALES
                                            ================================================================ */
        .content-wrapper {
            background: radial-gradient(circle at 80% 10%, rgba(45, 212, 191, 0.06), transparent 30rem),
                var(--surface-bg);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .content {
            padding-top: 10px;
        }

        h1,
        h2,
        h3,
        .card-title,
        .metric-value {
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: -0.02em;
        }

        .badge,
        .status-badge,
        .metric-label,
        .health-stat-title {
            font-family: 'IBM Plex Mono', monospace;
        }

        /* ================================================================
                                               HERO - MEDICAL COMMAND CENTER
                                            ================================================================ */
        .command-hero {
            position: relative;
            overflow: hidden;
            padding: 32px 32px 28px;
            border-radius: var(--radius-card);
            background: radial-gradient(circle at 70% 20%, rgba(45, 212, 191, 0.20), transparent 45%),
                linear-gradient(135deg, #071827 0%, #0A2A44 55%, #0F4F4A 100%);
            box-shadow: var(--shadow-lg);
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            color: #fff;
        }

        .command-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3;
            pointer-events: none;
        }

        .command-hero .hero-ekg {
            position: absolute;
            bottom: 12px;
            left: 0;
            width: 100%;
            height: 50px;
            opacity: 0.25;
            pointer-events: none;
        }

        .command-hero .hero-ekg path {
            stroke: var(--accent-teal-light);
            stroke-width: 2.5;
            fill: none;
            filter: drop-shadow(0 0 8px rgba(45, 212, 191, 0.4));
        }

        .hero-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
        }

        .hero-left .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(45, 212, 191, 0.12);
            border: 1px solid rgba(45, 212, 191, 0.20);
            border-radius: 999px;
            padding: 4px 14px 4px 10px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #A6F0E0;
        }

        .hero-left h1 {
            font-size: clamp(1.8rem, 3.5vw, 2.8rem);
            font-weight: 700;
            margin: 10px 0 6px;
            color: #fff;
            letter-spacing: -0.04em;
            line-height: 1.2;
        }

        .hero-left p {
            color: #C5D8E3;
            max-width: 580px;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 0;
        }

        .hero-right {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.10);
            border-radius: var(--radius-sm);
            padding: 18px 24px;
            min-width: 200px;
            text-align: right;
        }

        .hero-right .period-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #9AB8C9;
        }

        .hero-right .period-value {
            font-size: 1.4rem;
            font-weight: 700;
            color: #fff;
            margin-top: 2px;
        }

        .hero-right .doctor-name {
            font-size: 0.9rem;
            color: var(--accent-teal-light);
            font-weight: 600;
        }

        .live-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            background: rgba(45, 212, 191, 0.15);
            padding: 2px 12px;
            border-radius: 999px;
            font-size: 10px;
            color: #A6F0E0;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent-teal-light);
            display: inline-block;
            animation: pulseDot 2s infinite;
        }

        @keyframes pulseDot {
            0% {
                opacity: 0.6;
                transform: scale(1);
            }

            50% {
                opacity: 1;
                transform: scale(1.2);
            }

            100% {
                opacity: 0.6;
                transform: scale(1);
            }
        }

        /* ================================================================
                                               FILTROS SUPERPUESTOS
                                            ================================================================ */
        .filter-overlay {
            margin-top: -18px;
            position: relative;
            z-index: 5;
            background: var(--card-bg);
            backdrop-filter: blur(8px);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-sm);
            padding: 12px 16px;
        }

        .filter-overlay .form-control {
            height: 40px;
            border-radius: 10px;
            border: 1px solid #DDE8EE;
            background: #F9FCFD;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .filter-overlay .form-control:focus {
            border-color: var(--accent-teal);
            box-shadow: 0 0 0 3px rgba(15, 157, 138, 0.15);
        }

        .filter-overlay label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            margin-bottom: 2px;
        }

        .filter-overlay .btn-primary {
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent-teal), #0C7A6A);
            border: none;
            font-weight: 600;
            box-shadow: 0 8px 18px rgba(15, 157, 138, 0.30);
            transition: all 0.25s;
        }

        .filter-overlay .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(15, 157, 138, 0.40);
        }

        /* ================================================================
                                               TARJETAS DE INDICADORES (Power BI / Excel style)
                                            ================================================================ */
        .kpi-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-card);
            padding: 18px 20px 16px;
            box-shadow: var(--shadow-sm);
            transition: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .kpi-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: rgba(15, 157, 138, 0.3);
        }

        .kpi-card .kpi-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .kpi-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            background: var(--surface-bg);
            color: var(--primary-mid);
        }

        .kpi-badge {
            font-size: 0.6rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(15, 157, 138, 0.10);
            color: var(--accent-teal);
        }

        .kpi-label {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            margin-top: 10px;
        }

        .kpi-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.1;
            margin-top: 2px;
        }

        .kpi-foot {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 6px;
            border-top: 1px solid rgba(0, 0, 0, 0.04);
            padding-top: 8px;
        }

        /* Variantes de color para iconos */
        .kpi-icon.teal {
            background: rgba(15, 157, 138, 0.12);
            color: var(--accent-teal);
        }

        .kpi-icon.navy {
            background: rgba(10, 38, 71, 0.10);
            color: var(--primary-dark);
        }

        .kpi-icon.gold {
            background: rgba(200, 155, 60, 0.12);
            color: var(--accent-gold);
        }

        .kpi-icon.coral {
            background: rgba(214, 90, 90, 0.12);
            color: var(--accent-coral);
        }

        .kpi-icon.plum {
            background: rgba(123, 94, 167, 0.12);
            color: var(--accent-plum);
        }

        .kpi-icon.sky {
            background: rgba(59, 143, 194, 0.12);
            color: var(--accent-sky);
        }

        /* ================================================================
                                               TARJETAS DE GRÁFICAS UNIFORMES
                                            ================================================================ */
        .chart-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-sm);
            padding: 18px 18px 12px;
            height: 100%;
            transition: all 0.25s;
        }

        .chart-card:hover {
            box-shadow: var(--shadow-md);
        }

        .chart-card .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .chart-card .chart-title {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--text-dark);
            margin: 0;
        }

        .chart-card .chart-subtitle {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .chart-box {
            height: 280px;
            position: relative;
        }

        .chart-box-sm {
            height: 220px;
        }

        /* ================================================================
                                               META MENSUAL (Barra premium)
                                            ================================================================ */
        .meta-progress {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-card);
            padding: 18px 22px;
            box-shadow: var(--shadow-sm);
        }

        .meta-progress .meta-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .meta-progress .meta-label {
            font-weight: 600;
            color: var(--text-dark);
        }

        .meta-progress .meta-percent {
            font-weight: 700;
            color: var(--accent-teal);
        }

        .progress-bar-premium {
            height: 12px;
            border-radius: 999px;
            background: #E9F0F4;
            overflow: hidden;
            position: relative;
        }

        .progress-bar-premium .bar-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--accent-teal), var(--accent-teal-light));
            transition: width 1.2s cubic-bezier(0.2, 0.9, 0.4, 1);
            position: relative;
            box-shadow: 0 0 12px rgba(15, 157, 138, 0.4);
        }

        .progress-bar-premium .bar-fill::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 2.4s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .meta-details {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 6px;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .meta-details strong {
            color: var(--text-dark);
        }

        /* ================================================================
                                               ALERTAS DE CALIDAD (más visibles)
                                            ================================================================ */
        .alert-quality {
            border-radius: var(--radius-sm);
            border: none;
            padding: 14px 20px;
            background: #FFF8E7;
            border-left: 6px solid var(--accent-gold);
            box-shadow: var(--shadow-sm);
            color: #7A6310;
        }

        .alert-quality .alert-icon {
            font-size: 1.8rem;
            margin-right: 14px;
            opacity: 0.9;
        }

        .alert-quality strong {
            display: block;
            font-size: 1rem;
        }

        /* ================================================================
                                               LECTURA EJECUTIVA E HITOS COMBINADOS
                                            ================================================================ */
        .executive-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-card);
            padding: 18px 20px;
            box-shadow: var(--shadow-sm);
            height: 100%;
        }

        .executive-card .exec-title {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .executive-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .executive-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            font-size: 0.9rem;
            color: var(--text-dark);
        }

        .executive-list li:last-child {
            border-bottom: none;
        }

        .executive-list li i {
            color: var(--accent-teal);
            margin-top: 3px;
        }

        .milestone-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
        }

        .milestone-row:last-child {
            border-bottom: none;
        }

        .milestone-label {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .milestone-value {
            font-weight: 700;
            color: var(--text-dark);
        }

        /* ================================================================
                                               RESPONSIVE
                                            ================================================================ */
        @media (max-width: 767.98px) {
            .command-hero {
                padding: 20px 18px;
                border-radius: 18px;
            }

            .hero-left h1 {
                font-size: 1.8rem;
            }

            .hero-right {
                margin-top: 14px;
                text-align: left;
                width: 100%;
            }

            .filter-overlay {
                margin-top: -12px;
                padding: 12px;
            }

            .filter-overlay .row>div {
                margin-bottom: 8px;
            }

            .kpi-value {
                font-size: 1.8rem;
            }

            .chart-box {
                height: 220px;
            }

            .chart-box-sm {
                height: 180px;
            }

            .meta-progress {
                padding: 14px 16px;
            }

            .executive-card .exec-title {
                font-size: 0.95rem;
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) {
            .kpi-value {
                font-size: 2rem;
            }

            .chart-box {
                height: 250px;
            }
        }
    </style>
@stop

@section('content')

    @php
        /*
        |--------------------------------------------------------------------------
        | Valores seguros (misma lógica)
        |--------------------------------------------------------------------------
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
        $acumuladoHastaMes = $acumuladoHastaMes ?? 0;
        $mesesEvaluados = $mesesEvaluados ?? 0;
        $mesesConMovimiento = $mesesConMovimiento ?? 0;
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
            $coberturaRegistro >= 95 => ['texto' => 'Óptima', 'clase' => 'badge-soft-success'],
            $coberturaRegistro >= 80 => ['texto' => 'Aceptable', 'clase' => 'badge-soft-warning'],
            default => ['texto' => 'Requiere revisión', 'clase' => 'badge-soft-danger'],
        };

        $estadoVariacion = match (true) {
            is_null($variacionMes) => ['texto' => 'Sin comparación', 'clase' => 'text-muted', 'icono' => 'fa-minus'],
            $variacionMes > 0 => ['texto' => 'Incremento', 'clase' => 'text-success', 'icono' => 'fa-arrow-up'],
            $variacionMes < 0 => ['texto' => 'Disminución', 'clase' => 'text-danger', 'icono' => 'fa-arrow-down'],
            default => ['texto' => 'Sin cambio', 'clase' => 'text-muted', 'icono' => 'fa-equals'],
        };
    @endphp

    {{-- ================================================================
        HERO
    ================================================================ --}}
    <div class="command-hero">
        <svg class="hero-ekg" viewBox="0 0 900 60" preserveAspectRatio="none" aria-hidden="true">
            <path
                d="M0,30 L200,30 L220,30 L235,8 L255,52 L270,20 L290,30 L450,30 L470,30 L485,8 L505,52 L520,20 L540,30 L900,30" />
        </svg>
        <div class="hero-content">
            <div class="hero-left">
                <span class="hero-kicker"><i class="fas fa-heartbeat"></i> Medical Command Center</span>
                <h1>Panorama de Productividad Médica</h1>
                <p>Monitoreo ejecutivo de la actividad asistencial.</p>
                
            </div>
            <div class="hero-right">
                <div class="period-label">Periodo evaluado</div>
                <div class="period-value">{{ $mesNombre }} {{ $anio }}</div>
                <div class="doctor-name"><i class="fas fa-user-md"></i> {{ $resumenMedico }}</div>
                <span class="live-pill"><span class="live-dot"></span> Datos en vivo</span>
            </div>
        </div>
    </div>

    {{-- ================================================================
        FILTROS
    ================================================================ --}}
    <div class="filter-overlay">
        <form method="GET" action="{{ route('dashboard') }}">
            <div class="row align-items-end g-2">
                <div class="col-md-2 col-6">
                    <label for="anio">Año</label>
                    <input type="number" id="anio" name="anio" class="form-control" value="{{ $anio }}"
                        min="2000" max="2100" required>
                </div>
                <div class="col-md-2 col-6">
                    <label for="mes">Mes</label>
                    <select id="mes" name="mes" class="form-control" required>
                        @foreach ($meses as $numero => $nombre)
                            <option value="{{ $numero }}" {{ (int) $mes === (int) $numero ? 'selected' : '' }}>
                                {{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-6">
                    <label for="medico_id">Médico</label>
                    <select id="medico_id" name="medico_id" class="form-control">
                        <option value="">Todos los médicos</option>
                        @foreach ($medicos as $medico)
                            <option value="{{ $medico->id }}"
                                {{ (int) $medicoId === (int) $medico->id ? 'selected' : '' }}>{{ $medico->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <label for="meta_mensual">Meta mensual</label>
                    <input type="number" id="meta_mensual" name="meta_mensual" class="form-control"
                        value="{{ $metaMensual }}" min="0" placeholder="Opcional">
                </div>
                <div class="col-md-3 col-12">
                    <button type="submit" class="btn btn-primary w-100 btn-rounded">
                        <i class="fas fa-sync-alt mr-1"></i> Actualizar
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ================================================================
        INDICADORES ESTRATÉGICOS (4 KPIs)
    ================================================================ --}}
    <div class="row mt-4 g-3">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon navy"><i class="fas fa-hospital-user"></i></div>
                    <span class="kpi-badge">Mes actual</span>
                </div>
                <div class="kpi-label">Pacientes atendidos del mes</div>
                <div class="kpi-value">{{ $fmt($totalMes) }}</div>
                <div class="kpi-foot"><i class="fas fa-database mr-1"></i> Total oficial</div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon teal"><i class="fas fa-chart-line"></i></div>
                    <span class="kpi-badge">Acumulado</span>
                </div>
                <div class="kpi-label">Pacientes atendidos del año</div>
                <div class="kpi-value">{{ $fmt($totalAnio) }}</div>
                <div class="kpi-foot">Promedio mensual: <strong>{{ $fmtDecimal($promedioMensual) }}</strong></div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon gold"><i class="fas fa-chart-area"></i></div>
                    <span class="kpi-badge">Estimación</span>
                </div>
                <div class="kpi-label">Proyección anual</div>
                <div class="kpi-value">{{ $fmt($proyeccionAnual) }}</div>
                <div class="kpi-foot">Cierre estimado según ritmo actual</div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon sky"><i class="fas fa-calendar-check"></i></div>
                    <span class="kpi-badge {{ $estadoCobertura['clase'] }}">{{ $estadoCobertura['texto'] }}</span>
                </div>
                <div class="kpi-label">Cobertura del registro</div>
                <div class="kpi-value">{{ $fmtDecimal($coberturaRegistro) }}%</div>
                <div class="kpi-foot">{{ $diasConAtencion }} de {{ $diasLaborablesEvaluados }} días evaluados</div>
            </div>
        </div>
    </div>

    {{-- ================================================================
        MÉTRICAS OPERATIVAS (6 KPIs)
    ================================================================ --}}
    <div class="row mt-3 g-3">
        <div class="col-xl-2 col-lg-4 col-md-4 col-6">
            <div class="kpi-card" style="min-height:120px;">
                <div class="kpi-top">
                    <div class="kpi-icon plum"><i class="fas fa-calendar-day"></i></div>
                </div>
                <div class="kpi-label">Promedio / día laborable</div>
                <div class="kpi-value" style="font-size:1.8rem;">{{ $fmtDecimal($promedioDia) }}</div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-6">
            <div class="kpi-card" style="min-height:120px;">
                <div class="kpi-top">
                    <div class="kpi-icon coral"><i class="fas fa-calendar-alt"></i></div>
                </div>
                <div class="kpi-label">Meses con actividad</div>
                <div class="kpi-value" style="font-size:1.8rem;">{{ $mesesConMovimiento }} <span
                        style="font-size:1rem;color:var(--text-muted);">/ {{ $mesesEvaluados }}</span></div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-6">
            <div class="kpi-card" style="min-height:120px;">
                <div class="kpi-top">
                    <div class="kpi-icon gold"><i class="fas fa-bullseye"></i></div>
                </div>
                <div class="kpi-label">Proyección mensual</div>
                <div class="kpi-value" style="font-size:1.8rem;">{{ $fmt($proyeccionMensual) }}</div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-6">
            <div class="kpi-card" style="min-height:120px;">
                <div class="kpi-top">
                    <div class="kpi-icon teal"><i class="fas fa-child"></i></div>
                </div>
                <div class="kpi-label">Menores de 5 años</div>
                <div class="kpi-value" style="font-size:1.8rem;">{{ $fmt($totalMenoresCinco) }}</div>
                <div class="kpi-foot" style="font-size:0.7rem;">{{ $fmtDecimal($porcentajeMenoresCinco) }}% del total
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-6">
            <div class="kpi-card" style="min-height:120px;">
                <div class="kpi-top">
                    <div class="kpi-icon sky"><i class="fas fa-user-md"></i></div>
                </div>
                <div class="kpi-label">Médico líder</div>
                <div class="kpi-value" style="font-size:1.2rem;line-height:1.3;">
                    {{ \Illuminate\Support\Str::limit($topMedicoNombre, 20) }}</div>
                <div class="kpi-foot" style="font-size:0.7rem;">{{ $fmt($topMedicoTotal) }} pacientes ·
                    {{ $fmtDecimal($participacionTopMedico) }}%</div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-6">
            <div class="kpi-card" style="min-height:120px;">
                <div class="kpi-top">
                    <div class="kpi-icon coral"><i class="fas fa-exchange-alt"></i></div>
                </div>
                <div class="kpi-label">Variación mensual</div>
                <div class="kpi-value {{ $estadoVariacion['clase'] }}" style="font-size:1.8rem;">
                    @if (!is_null($variacionMes))
                        <i class="fas {{ $estadoVariacion['icono'] }} mr-1"></i>
                        {{ $variacionMes > 0 ? '+' : '' }}{{ $fmtDecimal($variacionMes) }}%
                    @else
                        N/D
                    @endif
                </div>
                <div class="kpi-foot" style="font-size:0.7rem;">{{ $estadoVariacion['texto'] }}</div>
            </div>
        </div>
    </div>

    {{-- ================================================================
        ALERTAS DE CALIDAD
    ================================================================ --}}
    @if ($diasSinRegistro > 0 || $registrosFinSemana > 0)
        <div class="row mt-3 g-3">
            @if ($diasSinRegistro > 0)
                <div class="col-md-6">
                    <div class="alert-quality d-flex align-items-center">
                        <div class="alert-icon"><i class="fas fa-calendar-times"></i></div>
                        <div>
                            <strong>Días laborables sin registro</strong>
                            <span>Se identificaron {{ $diasSinRegistro }} días laborables sin pacientes
                                atendidos.</span>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    @endif

    {{-- ================================================================
        META MENSUAL
    ================================================================ --}}
    @if (!is_null($cumplimientoMeta))
        <div class="row mt-3">
            <div class="col-12">
                <div class="meta-progress">
                    <div class="meta-header">
                        <span class="meta-label"><i class="fas fa-bullseye text-primary mr-1"></i> Cumplimiento de meta
                            mensual</span>
                        <span class="meta-percent">{{ $fmtDecimal($cumplimientoMeta) }}%</span>
                    </div>
                    <div class="progress-bar-premium">
                        <div class="bar-fill" style="width: {{ min($cumplimientoMeta, 100) }}%;"></div>
                    </div>
                    <div class="meta-details">
                        <span>Meta: <strong>{{ $fmt($metaMensual) }}</strong> pacientes</span>
                        <span>Actual: <strong>{{ $fmt($totalMes) }}</strong> pacientes</span>
                        @if ($faltanteMeta > 0)
                            <span class="text-danger">Faltan: <strong>{{ $fmt($faltanteMeta) }}</strong> pacientes</span>
                        @else
                            <span class="text-success"><strong>¡Meta alcanzada!</strong></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ================================================================
        GRÁFICAS Y LECTURA EJECUTIVA
    ================================================================ --}}
    <div class="row mt-4 g-3">
        {{-- Tendencia anual --}}
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <div>
                        <div class="chart-title">Tendencia anual de pacientes</div>
                        <div class="chart-subtitle">Total mensual durante {{ $anio }}</div>
                    </div>
                    <i class="fas fa-chart-area" style="color:var(--accent-teal);font-size:1.4rem;"></i>
                </div>
                <div class="chart-box">
                    <canvas id="chartMeses"></canvas>
                </div>
            </div>
        </div>

        {{-- Lectura ejecutiva e hitos --}}
        <div class="col-lg-4">
            <div class="executive-card">
                <div class="exec-title"><i class="fas fa-clipboard-list mr-2" style="color:var(--accent-teal);"></i>
                    Lectura ejecutiva &amp; hitos</div>
                @if (count($lecturaEjecutiva) > 0)
                    <ul class="executive-list">
                        @foreach ($lecturaEjecutiva as $lectura)
                            <li><i class="fas fa-check-circle"></i> {{ $lectura }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted text-center py-2">Sin observaciones para el periodo.</p>
                @endif
                <hr style="margin:12px 0;">
                <div>
                    <div class="milestone-row">
                        <span class="milestone-label">Mes de mayor atención</span>
                        <span class="milestone-value">{{ $mejorMes['nombre'] ?? '-' }}
                            ({{ $fmt($mejorMes['total'] ?? 0) }})</span>
                    </div>
                    <div class="milestone-row">
                        <span class="milestone-label">Día laborable de mayor carga</span>
                        <span class="milestone-value">Día {{ $mejorDia['dia'] ?? '-' }}
                            ({{ $fmt($mejorDia['total'] ?? 0) }})</span>
                    </div>
                    <div class="milestone-row">
                        <span class="milestone-label">Promedio en días activos</span>
                        <span class="milestone-value">{{ $fmtDecimal($promedioPorDiaConActividad) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================
        ACTIVIDAD DIARIA Y TOP CONCEPTOS
    ================================================================ --}}
    <div class="row mt-3 g-3">
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <div>
                        <div class="chart-title">Pacientes por día laborable</div>
                        <div class="chart-subtitle">Actividad diaria de {{ $mesNombre }}. (Sábados y domingos
                            excluidos)</div>
                    </div>
                    <i class="fas fa-calendar-day" style="color:var(--accent-plum);font-size:1.4rem;"></i>
                </div>
                <div class="chart-box">
                    <canvas id="chartDias"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-header">
                    <div>
                        <div class="chart-title">Principales servicios</div>
                        <div class="chart-subtitle">Excluye filas automáticas 19 y 44</div>
                    </div>
                    <i class="fas fa-clipboard-list" style="color:var(--accent-gold);font-size:1.4rem;"></i>
                </div>
                <div class="chart-box-sm">
                    <canvas id="chartConceptos"></canvas>
                </div>
                <div style="margin-top:8px;font-size:0.85rem;">
                    <span class="badge" style="background:var(--accent-gold);color:#fff;">Principal</span>
                    <strong>{{ $topConceptoNombre }}</strong>
                    <span class="text-muted">· {{ $topConceptoCodigo }} · {{ $fmt($topConceptoTotal) }} registros ·
                        {{ $fmtDecimal($participacionTopConcepto) }}%</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================
        DISTRIBUCIÓN POR MÉDICO Y RESUMEN DEL LÍDER
    ================================================================ --}}
    <div class="row mt-3 g-3">
        <div class="col-lg-7">
            <div class="chart-card">
                <div class="chart-header">
                    <div>
                        <div class="chart-title">Distribución de pacientes por médico</div>
                        <div class="chart-subtitle">Volumen de atención en el periodo</div>
                    </div>
                    <i class="fas fa-user-md" style="color:var(--accent-coral);font-size:1.4rem;"></i>
                </div>
                <div class="chart-box">
                    <canvas id="chartMedicos"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="executive-card">
                <div class="exec-title"><i class="fas fa-trophy mr-2" style="color:var(--accent-gold);"></i> Médico líder
                    del mes</div>
                <div class="d-flex align-items-center mb-3">
                    <div class="kpi-icon plum" style="margin-right:14px;"><i class="fas fa-user-md"></i></div>
                    <div>
                        <div class="kpi-label" style="font-size:0.65rem;">Mayor volumen</div>
                        <strong style="font-size:1.2rem;">{{ $topMedicoNombre }}</strong>
                        <div class="text-muted" style="font-size:0.9rem;">{{ $fmt($topMedicoTotal) }} pacientes atendidos
                        </div>
                    </div>
                </div>
                <div class="milestone-row">
                    <span class="milestone-label">Participación del total mensual</span>
                    <span class="milestone-value">{{ $fmtDecimal($participacionTopMedico) }}%</span>
                </div>
                <div class="milestone-row">
                    <span class="milestone-label">Total institucional del mes</span>
                    <span class="milestone-value">{{ $fmt($totalMes) }}</span>
                </div>
                <div class="milestone-row">
                    <span class="milestone-label">Diferencia frente al total</span>
                    <span class="milestone-value">{{ $fmt(max(0, $totalMes - $topMedicoTotal)) }}</span>
                </div>

            </div>
        </div>
    </div>
    <div class="mt-4 pt-3" style="border-top:1px solid rgba(10,38,71,0.08);">
        <div class="d-flex justify-content-center">
            <div class="px-4 py-2 text-center"
                style="border-radius:14px;background:linear-gradient(135deg, rgba(10,38,71,0.06), rgba(91,33,182,0.05));box-shadow:0 6px 18px rgba(10,38,71,0.06);">
                <div style="font-size:0.72rem;letter-spacing:.08em;text-transform:uppercase;color:#6B7F8D;">
                    Desarrollado por
                </div>
                <div style="font-size:0.95rem;font-weight:700;color:#0A2647;line-height:1.2;">
                    Jose Hernandez
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Datos desde PHP
            const mesesLabels = @json($chartMesesLabels ?? []);
            const datosMeses = @json($chartMesesData ?? []);
            const diasLabels = @json($chartDiasLabels ?? []);
            const datosDias = @json($chartDiasData ?? []);
            const conceptosLabels = @json($chartConceptosLabels ?? []);
            const conceptosData = @json($chartConceptosData ?? []);
            const medicosLabels = @json($chartMedicosLabels ?? []);
            const medicosData = @json($chartMedicosData ?? []);

            // Registro global del plugin datalabels
            Chart.register(ChartDataLabels);

            // Configuración global
            Chart.defaults.font.family = "'Inter', system-ui, sans-serif";
            Chart.defaults.color = '#6B7F8D';

            const gridColor = 'rgba(10, 38, 71, 0.06)';

            function fmt(val) {
                return new Intl.NumberFormat('es-HN').format(val || 0);
            }

            function gradiente(ctx, color1, color2) {
                const g = ctx.createLinearGradient(0, 0, 0, 280);
                g.addColorStop(0, color1);
                g.addColorStop(1, color2);
                return g;
            }

            // ---- Tendencia anual ----
            const ctxMeses = document.getElementById('chartMeses')?.getContext('2d');
            if (ctxMeses) {
                new Chart(ctxMeses, {
                    type: 'line',
                    data: {
                        labels: mesesLabels,
                        datasets: [{
                            label: 'Pacientes',
                            data: datosMeses,
                            borderColor: '#0F9D8A',
                            backgroundColor: gradiente(ctxMeses, 'rgba(15,157,138,0.25)',
                                'rgba(15,157,138,0.01)'),
                            pointBackgroundColor: '#0F9D8A',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 3.5,
                            pointHoverRadius: 6,
                            borderWidth: 3,
                            tension: 0.35,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: ctx => 'Pacientes: ' + fmt(ctx.raw)
                                }
                            },
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                color: '#0A2647',
                                font: {
                                    weight: 'bold',
                                    size: 9
                                },
                                formatter: v => fmt(v),
                                offset: 2
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: 'Meses del año',
                                    color: '#6B7F8D',
                                    font: {
                                        weight: 'bold',
                                        size: 10
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    callback: v => fmt(v)
                                },
                                grid: {
                                    color: gridColor
                                },
                                title: {
                                    display: true,
                                    text: 'Pacientes atendidos',
                                    color: '#6B7F8D',
                                    font: {
                                        weight: 'bold',
                                        size: 10
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // ---- Actividad diaria ----
            const ctxDias = document.getElementById('chartDias')?.getContext('2d');
            if (ctxDias) {
                new Chart(ctxDias, {
                    type: 'bar',
                    data: {
                        labels: diasLabels,
                        datasets: [{
                            label: 'Pacientes',
                            data: datosDias,
                            backgroundColor: 'rgba(10, 38, 71, 0.75)',
                            borderColor: '#0A2647',
                            borderWidth: 1,
                            borderRadius: 6,
                            maxBarThickness: 28
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    title: items => 'Día ' + items[0].label,
                                    label: ctx => 'Pacientes: ' + fmt(ctx.raw)
                                }
                            },
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                color: '#0A2647',
                                font: {
                                    weight: 'bold',
                                    size: 9
                                },
                                formatter: v => fmt(v),
                                offset: 2
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: 'Día laborable del mes',
                                    color: '#6B7F8D',
                                    font: {
                                        weight: 'bold',
                                        size: 10
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    callback: v => fmt(v)
                                },
                                grid: {
                                    color: gridColor
                                },
                                title: {
                                    display: true,
                                    text: 'Pacientes',
                                    color: '#6B7F8D',
                                    font: {
                                        weight: 'bold',
                                        size: 10
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // ---- Top conceptos ----
            const ctxConceptos = document.getElementById('chartConceptos')?.getContext('2d');
            if (ctxConceptos) {
                new Chart(ctxConceptos, {
                    type: 'bar',
                    data: {
                        labels: conceptosLabels,
                        datasets: [{
                            label: 'Registros',
                            data: conceptosData,
                            backgroundColor: 'rgba(200, 155, 60, 0.75)',
                            borderColor: '#C89B3C',
                            borderWidth: 1,
                            borderRadius: 6,
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
                                    label: ctx => 'Registros: ' + fmt(ctx.raw)
                                }
                            },
                            datalabels: {
                                anchor: 'end',
                                align: 'right',
                                color: '#0A2647',
                                font: {
                                    weight: 'bold',
                                    size: 9
                                },
                                formatter: v => fmt(v),
                                offset: 2
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    callback: v => fmt(v)
                                },
                                grid: {
                                    color: gridColor
                                },
                                title: {
                                    display: true,
                                    text: 'Registros',
                                    color: '#6B7F8D',
                                    font: {
                                        weight: 'bold',
                                        size: 10
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    autoSkip: false,
                                    font: {
                                        size: 10
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // ---- Ranking médicos ----
            const ctxMedicos = document.getElementById('chartMedicos')?.getContext('2d');
            if (ctxMedicos) {
                new Chart(ctxMedicos, {
                    type: 'bar',
                    data: {
                        labels: medicosLabels,
                        datasets: [{
                            label: 'Pacientes',
                            data: medicosData,
                            backgroundColor: 'rgba(123, 94, 167, 0.75)',
                            borderColor: '#7B5EA7',
                            borderWidth: 1,
                            borderRadius: 6,
                            maxBarThickness: 32
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
                                    label: ctx => 'Pacientes: ' + fmt(ctx.raw)
                                }
                            },
                            datalabels: {
                                anchor: 'end',
                                align: 'right',
                                color: '#0A2647',
                                font: {
                                    weight: 'bold',
                                    size: 9
                                },
                                formatter: v => fmt(v),
                                offset: 2
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    callback: v => fmt(v)
                                },
                                grid: {
                                    color: gridColor
                                },
                                title: {
                                    display: true,
                                    text: 'Pacientes atendidos',
                                    color: '#6B7F8D',
                                    font: {
                                        weight: 'bold',
                                        size: 10
                                    }
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
