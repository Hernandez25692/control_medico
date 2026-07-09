@extends('adminlte::page')

@section('title', 'Consolidado Anual')

@section('content_header')
    <h1>Consolidado Anual</h1>
@stop

@section('content')

    <div class="card shadow-sm clinic-sheet-card">
        @if ($cerrados == 12)
            <div class="alert alert-success mb-3 d-flex align-items-center gap-2">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>Año cerrado.</strong>
                    Todos los meses del año están cerrados.
                </div>
            </div>
        @else
            <div class="alert alert-warning mb-3 d-flex align-items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Año en curso.</strong>
                    {{ 12 - $cerrados }} mes(es) permanecen abiertos.
                </div>
            </div>
        @endif

        <div class="card-header bg-white sheet-toolbar">
            <form method="GET" action="{{ route('consolidado-anual.index') }}" class="row align-items-end">

                <div class="col-md-3 toolbar-field">
                    <label>Año</label>
                    <input type="number" name="anio" class="form-control" value="{{ $anio }}">
                </div>

                <div class="col-md-4 toolbar-field">
                    <label>Tipo de reporte</label>
                    <select name="tipo" class="form-control">
                        <option value="resumen" {{ $tipo === 'resumen' ? 'selected' : '' }}>Resumen general</option>
                        <option value="medico" {{ $tipo === 'medico' ? 'selected' : '' }}>Resumen por médico</option>
                        <option value="detalle" {{ $tipo === 'detalle' ? 'selected' : '' }}>Detalle mensual</option>
                    </select>
                </div>

                <div class="col-md-3 toolbar-field">
                    <button class="btn btn-primary btn-block">
                        <i class="fas fa-search"></i> Consultar
                    </button>
                </div>

            </form>
        </div>

        <div class="card-body">
            @if ($tipo === 'resumen')
                @include('consolidados.partials.anual-resumen')
            @elseif ($tipo === 'medico')
                @include('consolidados.partials.anual-medico')
            @else
                @include('consolidados.partials.anual-detalle')
            @endif
        </div>
    </div>

@stop

@section('css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --navy: #0B3B5C;
            --navy-dark: #082A44;
            --teal: #1E8A75;
            --teal-light: #2FB39A;
            --teal-tint: #E4F5F1;
            --amber: #B9821E;
            --amber-tint: #FFF6E0;
            --ink: #16232E;
            --muted: #6B7A88;
            --grid-line: #DCE4EA;
            --total-tint: #EAF1F7;
        }

        /* ---------- Tarjeta y alertas ---------- */

        .clinic-sheet-card {
            border: 1px solid var(--grid-line);
            border-radius: 12px;
        }

        .clinic-sheet-card .alert {
            border-radius: 10px 10px 0 0;
            margin: 0;
            font-family: 'Inter', sans-serif;
            font-size: 13.5px;
        }

        .clinic-sheet-card .alert i {
            font-size: 16px;
        }

        .gap-2 {
            gap: 8px;
        }

        /* ---------- Toolbar de filtros ---------- */

        .sheet-toolbar {
            background: #FAFBFC !important;
            border-bottom: 1px solid var(--grid-line);
            padding: 18px 20px;
        }

        .toolbar-field label {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 5px;
        }

        .toolbar-field .form-control {
            border: 1.5px solid var(--grid-line);
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 13.5px;
            height: 40px;
        }

        .toolbar-field .form-control:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(30, 138, 117, 0.12);
        }

        .toolbar-field .btn-primary {
            background: linear-gradient(135deg, var(--teal) 0%, #17705F 100%);
            border: none;
            height: 40px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13.5px;
            box-shadow: 0 8px 18px -8px rgba(30, 138, 117, 0.55);
        }

        .toolbar-field .btn-primary:hover {
            background: linear-gradient(135deg, #1c7c69 0%, #146253 100%);
        }

        /* ---------- Contenedor / hoja de cálculo ---------- */

        .contenedor-tabla {
            max-height: 680px;
            overflow: auto;
            border: 1px solid var(--grid-line);
            border-radius: 10px;
            background: #fff;
        }

        .tabla-consolidado {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13.5px;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .tabla-consolidado th,
        .tabla-consolidado td {
            border: 1px solid var(--grid-line) !important;
            vertical-align: middle;
            white-space: nowrap;
        }

        /* Encabezado tipo Excel */
        .tabla-consolidado th {
            position: sticky;
            top: 0;
            z-index: 10;
            background: var(--navy);
            color: #fff;
            text-align: center;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 12.5px;
            letter-spacing: 0.02em;
            padding: 12px 10px;
            border-color: var(--navy-dark) !important;
        }

        .tabla-consolidado td {
            padding: 10px 12px;
        }

        /* Columnas congeladas (freeze panes) */
        .col-numero {
            min-width: 60px;
            position: sticky;
            left: 0;
            background: #F3F6F8;
            z-index: 8;
            text-align: center;
            font-weight: 700;
            color: var(--navy);
        }

        .col-concepto {
            min-width: 420px;
            position: sticky;
            left: 60px;
            background: #ffffff;
            z-index: 8;
            font-family: 'Inter', sans-serif;
            font-size: 13.5px;
            box-shadow: 3px 0 6px -3px rgba(11, 59, 92, 0.15);
        }

        thead .col-numero {
            background: var(--navy);
            color: #fff;
            z-index: 20;
        }

        thead .col-concepto {
            background: var(--navy);
            color: #fff;
            z-index: 20;
            box-shadow: none;
            text-align: left;
        }

        /* Celdas con datos y totales */
        .celda-dato {
            background: var(--teal-tint);
            color: #146455;
            font-weight: 600;
        }

        .celda-total {
            background: var(--total-tint);
            color: var(--navy);
            font-weight: 700;
        }

        /* Filas automáticas / calculadas */
        .fila-automatica td,
        .fila-automatica .col-numero,
        .fila-automatica .col-concepto {
            background: var(--amber-tint) !important;
            color: var(--amber);
            font-weight: 700;
        }

        .fila-automatica:hover td {
            background: var(--amber-tint) !important;
        }

        /* Hover tipo hoja de cálculo */
        .tabla-consolidado tbody tr:hover td:not(.col-numero):not(.col-concepto) {
            background: #F0F7FC;
        }

        .tabla-consolidado tbody tr:hover .col-numero,
        .tabla-consolidado tbody tr:hover .col-concepto {
            background: #E7EFF4;
        }

        /* Scrollbar más discreta */
        .contenedor-tabla::-webkit-scrollbar {
            height: 10px;
            width: 10px;
        }

        .contenedor-tabla::-webkit-scrollbar-track {
            background: #F3F6F8;
        }

        .contenedor-tabla::-webkit-scrollbar-thumb {
            background: #C3D0DA;
            border-radius: 6px;
        }

        .contenedor-tabla::-webkit-scrollbar-thumb:hover {
            background: var(--teal);
        }
    </style>
@stop
