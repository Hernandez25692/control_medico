@extends('adminlte::page')

@section('title', 'Consolidado Anual')

@section('content_header')
    <h1>Consolidado Anual</h1>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <form method="GET" action="{{ route('consolidado-anual.index') }}" class="row">

                <div class="col-md-3">
                    <label>Año</label>
                    <input type="number" name="anio" class="form-control" value="{{ $anio }}">
                </div>

                <div class="col-md-4">
                    <label>Tipo de reporte</label>
                    <select name="tipo" class="form-control">
                        <option value="resumen" {{ $tipo === 'resumen' ? 'selected' : '' }}>Resumen general</option>
                        <option value="medico" {{ $tipo === 'medico' ? 'selected' : '' }}>Resumen por médico</option>
                        <option value="detalle" {{ $tipo === 'detalle' ? 'selected' : '' }}>Detalle mensual</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary">
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
    <style>
        .contenedor-tabla {
            max-height: 680px;
            overflow: auto;
            border: 1px solid #dee2e6;
        }

        .tabla-consolidado {
            font-size: 13px;
            margin-bottom: 0;
        }

        .tabla-consolidado th {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #e9ecef;
            text-align: center;
            white-space: nowrap;
        }

        .tabla-consolidado td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .col-numero {
            min-width: 55px;
            position: sticky;
            left: 0;
            background: #fff;
            z-index: 8;
        }

        .col-concepto {
            min-width: 390px;
            position: sticky;
            left: 55px;
            background: #fff;
            z-index: 8;
        }

        thead .col-numero,
        thead .col-concepto {
            z-index: 20;
            background: #dfe4ea;
        }

        .celda-dato {
            background: #d4edda;
            font-weight: bold;
        }

        .celda-total {
            background: #d1ecf1;
            font-weight: bold;
        }

        .fila-automatica td,
        .fila-automatica .col-numero,
        .fila-automatica .col-concepto {
            background: #fff3cd !important;
            font-weight: bold;
        }
    </style>
@stop
