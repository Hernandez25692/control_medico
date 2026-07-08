@extends('adminlte::page')

@section('title', 'Consolidado Mensual')

@section('content_header')
    <h1>Consolidado Mensual</h1>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <form method="GET" action="{{ route('consolidado-mensual.index') }}" class="row">
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

                <div class="col-md-2">
                    <label>Año</label>
                    <input type="number" name="anio" class="form-control" value="{{ $anio }}">
                </div>
                <div class="col-md-3">
                    <label>Tipo de reporte</label>
                    <select name="tipo" class="form-control">
                        <option value="resumen" {{ $tipo === 'resumen' ? 'selected' : '' }}>Resumen mensual</option>
                        <option value="detalle" {{ $tipo === 'detalle' ? 'selected' : '' }}>Detalle diario</option>
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
                @include('consolidados.partials.mensual-resumen')
            @else
                @include('consolidados.partials.mensual-detalle')
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
        }

        .fila-total td {
            background: #d1ecf1 !important;
            font-weight: bold;
            position: sticky;
            bottom: 0;
            z-index: 12;
            text-align: center;
        }
    </style>
@stop
