@extends('adminlte::page')

@section('title', 'Centro de Reportes')

@section('content_header')
    <h1>Centro de Reportes</h1>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h3 class="card-title">
                <i class="fas fa-file-excel"></i> Exportación de Información
            </h3>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('reportes.exportar') }}" class="row">

                <div class="col-md-3">
                    <label>Reporte</label>
                    <select name="reporte" id="reporte" class="form-control">
                        <option value="mensual">Consolidado Mensual</option>
                        <option value="anual">Consolidado Anual</option>
                    </select>
                </div>

                <div class="col-md-3" id="grupoMes">
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
                            <option value="{{ $numero }}" {{ date('n') == $numero ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Año</label>
                    <input type="number" name="anio" class="form-control" value="{{ date('Y') }}">
                </div>

                <div class="col-md-3">
                    <label>Tipo de vista</label>
                    <select name="tipo" class="form-control">
                        <option value="resumen">Resumen general</option>
                        <option value="medico">Resumen por médico</option>
                        <option value="detalle">Detalle</option>
                    </select>
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button class="btn btn-success btn-block">
                        <i class="fas fa-file-excel"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>

@stop

@section('js')
    <script>
        $(function() {
            $('#reporte').change(function() {
                if ($(this).val() === 'anual') {
                    $('#grupoMes').hide();
                } else {
                    $('#grupoMes').show();
                }
            });
        });
    </script>
@stop
