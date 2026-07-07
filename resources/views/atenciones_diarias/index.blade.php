@extends('adminlte::page')

@section('title', 'Atenciones Diarias')

@section('content_header')
    <h1>Registro Diario de Atenciones Médicas</h1>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <form method="GET" action="{{ route('atenciones-diarias.index') }}" class="row">

                <div class="col-md-4">
                    <label>Médico</label>
                    <select name="medico_id" class="form-control">
                        @foreach ($medicos as $medico)
                            <option value="{{ $medico->id }}" {{ $medicoId == $medico->id ? 'selected' : '' }}>
                                {{ $medico->codigo }} - {{ $medico->nombre }}
                            </option>
                        @endforeach
                    </select>
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

                <div class="col-md-2">
                    <label>Año</label>
                    <input type="number" name="anio" class="form-control" value="{{ $anio }}">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary mr-2">
                        <i class="fas fa-search"></i> Consultar
                    </button>

                    <button type="button" id="btnGuardar" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>

            </form>
        </div>

        <div class="card-body">
            <form id="formAtenciones">
                @csrf

                <input type="hidden" name="medico_id" value="{{ $medicoId }}">
                <input type="hidden" name="mes" value="{{ $mes }}">
                <input type="hidden" name="anio" value="{{ $anio }}">

                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover tabla-atenciones">
                        <thead>
                            <tr class="text-center">
                                <th style="min-width:50px;">Nº</th>
                                <th style="min-width:360px;">Concepto</th>

                                @for ($dia = 1; $dia <= $diasMes; $dia++)
                                    <th style="min-width:55px;">{{ $dia }}</th>
                                @endfor

                                <th style="min-width:80px;">Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($conceptos as $concepto)
                                @php
                                    $totalFila = 0;
                                @endphp

                                <tr>
                                    <td class="text-center font-weight-bold">{{ $loop->iteration }}</td>
                                    <td>{{ $concepto->nombre }}</td>

                                    @for ($dia = 1; $dia <= $diasMes; $dia++)
                                        @php
                                            $key = $concepto->id . '_' . $dia;
                                            $valor = $registros[$key]->cantidad ?? 0;
                                            $totalFila += $valor;
                                        @endphp

                                        <td>
                                            <input type="number" min="0"
                                                class="form-control form-control-sm text-center cantidad-dia"
                                                name="datos[{{ $concepto->id }}][{{ $dia }}]"
                                                value="{{ $valor }}" data-concepto="{{ $concepto->id }}">
                                        </td>
                                    @endfor

                                    <td class="text-center font-weight-bold total-fila">
                                        {{ $totalFila }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr class="bg-light font-weight-bold text-center">
                                <td colspan="2">TOTAL POR DÍA</td>

                                @for ($dia = 1; $dia <= $diasMes; $dia++)
                                    @php
                                        $totalDia = 0;
                                        foreach ($conceptos as $concepto) {
                                            $key = $concepto->id . '_' . $dia;
                                            $totalDia += $registros[$key]->cantidad ?? 0;
                                        }
                                    @endphp

                                    <td class="total-dia" data-dia="{{ $dia }}">{{ $totalDia }}</td>
                                @endfor

                                <td id="granTotal">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
        </div>
    </div>

@stop

@section('css')
    <style>
        .tabla-atenciones th {
            background: #f4f6f9;
            vertical-align: middle;
            white-space: nowrap;
        }

        .tabla-atenciones td {
            vertical-align: middle;
        }

        .tabla-atenciones input {
            padding: 2px;
            height: 30px;
        }

        .tabla-atenciones tbody tr:hover {
            background: #eef6ff;
        }

        .table-responsive {
            max-height: 650px;
            overflow: auto;
        }

        .tabla-atenciones thead th {
            position: sticky;
            top: 0;
            z-index: 5;
        }

        .tabla-atenciones th:first-child,
        .tabla-atenciones td:first-child {
            position: sticky;
            left: 0;
            background: #ffffff;
            z-index: 4;
        }

        .tabla-atenciones th:nth-child(2),
        .tabla-atenciones td:nth-child(2) {
            position: sticky;
            left: 50px;
            background: #ffffff;
            z-index: 4;
        }

        .tabla-atenciones thead th:first-child,
        .tabla-atenciones thead th:nth-child(2) {
            z-index: 8;
            background: #e9ecef;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            calcularTotales();

            $('.cantidad-dia').on('input', function() {
                calcularTotales();
            });

            $('#btnGuardar').click(function() {
                $.ajax({
                    url: "{{ route('atenciones-diarias.guardar') }}",
                    method: "POST",
                    data: $('#formAtenciones').serialize(),
                    beforeSend: function() {
                        $('#btnGuardar').prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin"></i> Guardando...');
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Correcto',
                            text: response.message,
                            timer: 1600,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo guardar el registro.'
                        });
                    },
                    complete: function() {
                        $('#btnGuardar').prop('disabled', false).html(
                            '<i class="fas fa-save"></i> Guardar');
                    }
                });
            });

            function calcularTotales() {
                let granTotal = 0;

                $('tbody tr').each(function() {
                    let totalFila = 0;

                    $(this).find('.cantidad-dia').each(function() {
                        totalFila += parseInt($(this).val()) || 0;
                    });

                    $(this).find('.total-fila').text(totalFila);
                    granTotal += totalFila;
                });

                $('.total-dia').each(function() {
                    let dia = $(this).data('dia');
                    let totalDia = 0;

                    $(`input[name$="[${dia}]"]`).each(function() {
                        totalDia += parseInt($(this).val()) || 0;
                    });

                    $(this).text(totalDia);
                });

                $('#granTotal').text(granTotal);
            }
        });
    </script>
@stop
