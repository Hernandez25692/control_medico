@extends('adminlte::page')

@section('title', 'Atenciones Diarias')

@section('content_header')
    <h1>Registro Diario de Atenciones Médicas</h1>
@stop

@section('content')

    <div class="card shadow-sm">
        @if ($periodo->cerrado)
            <div class="alert alert-danger mb-3">
                <i class="fas fa-lock"></i>
                <strong>Período Cerrado.</strong>

                @if (auth()->user()->hasRole('Administrador'))
                    Solo el administrador puede realizar modificaciones.
                @else
                    No es posible editar registros de este período.
                @endif
            </div>
        @else
            <div class="alert alert-success mb-3">
                <i class="fas fa-lock-open"></i>
                <strong>Período Abierto.</strong>
                Los registros pueden modificarse.
            </div>
        @endif
        <div class="card-header bg-white">
            <form method="GET" action="{{ route('atenciones-diarias.index') }}" class="row">

                @if (auth()->user()->hasRole('Administrador'))
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
                @else
                    <div class="col-md-4">
                        <label>Médico</label>
                        <input type="text" class="form-control"
                            value="{{ auth()->user()->medico->codigo }} - {{ auth()->user()->medico->nombre }}" readonly>
                    </div>
                @endif

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
                    <button class="btn btn-primary">
                        <i class="fas fa-search"></i> Consultar
                    </button>
                </div>

            </form>
        </div>

        <div class="card-body">

            <div class="mb-2">
                <span class="badge badge-success">Autoguardado activo</span>
                <span class="badge badge-warning">Filas automáticas bloqueadas</span>
                <span class="badge badge-info" id="estadoGuardado">Listo</span>
            </div>

            <input type="hidden" id="medico_id" value="{{ $medicoId }}">
            <input type="hidden" id="mes" value="{{ (int) $mes }}">
            <input type="hidden" id="anio" value="{{ (int) $anio }}">

            <div class="table-responsive contenedor-tabla">
                <table class="table table-bordered table-sm tabla-atenciones">
                    <thead>
                        <tr class="text-center">
                            <th class="col-numero">Nº</th>
                            <th class="col-concepto">Concepto</th>

                            @for ($dia = 1; $dia <= $diasMes; $dia++)
                                <th class="col-dia">{{ $dia }}</th>
                            @endfor

                            <th class="col-total">Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($conceptos as $concepto)
                            @php
                                $orden = (int) $concepto->orden;
                                $esAutomatico = in_array($orden, [19, 44]);
                                $totalFila = 0;
                            @endphp

                            <tr class="{{ $esAutomatico ? 'fila-automatica' : '' }}" data-orden="{{ $orden }}">
                                <td class="text-center font-weight-bold col-numero">
                                    {{ $orden }}
                                </td>

                                <td class="font-weight-bold col-concepto">
                                    {{ $concepto->nombre }}
                                </td>

                                @for ($dia = 1; $dia <= $diasMes; $dia++)
                                    @php
                                        $key = $concepto->id . '_' . $dia;
                                        $valor = $registros[$key]->cantidad ?? 0;
                                        $totalFila += $valor;
                                    @endphp

                                    <td>
                                        <input type="number" min="0" value="{{ $valor }}"
                                            class="form-control form-control-sm text-center cantidad-dia {{ $valor > 0 ? 'celda-con-dato' : '' }}"
                                            data-concepto="{{ $concepto->id }}" data-orden="{{ $orden }}"
                                            data-dia="{{ $dia }}" {{ $esAutomatico ? 'readonly' : '' }}>
                                    </td>
                                @endfor

                                <td class="text-center font-weight-bold total-fila">
                                    {{ $totalFila }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr class="fila-total-dia text-center">
                            <td colspan="2">TOTAL POR DÍA</td>

                            @for ($dia = 1; $dia <= $diasMes; $dia++)
                                <td class="total-dia" data-dia="{{ $dia }}">0</td>
                            @endfor

                            <td id="granTotal">0</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
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

        .tabla-atenciones {
            margin-bottom: 0;
            font-size: 13px;
        }

        .tabla-atenciones th {
            background: #e9ecef;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .tabla-atenciones td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .col-numero {
            min-width: 55px;
            width: 55px;
            position: sticky;
            left: 0;
            background: #ffffff;
            z-index: 8;
        }

        .col-concepto {
            min-width: 390px;
            width: 390px;
            position: sticky;
            left: 55px;
            background: #ffffff;
            z-index: 8;
        }

        thead .col-numero,
        thead .col-concepto {
            z-index: 20;
            background: #dfe4ea;
        }

        .col-dia {
            min-width: 55px;
        }

        .col-total {
            min-width: 85px;
            background: #d1ecf1 !important;
        }

        .cantidad-dia {
            height: 30px;
            padding: 2px;
            border-radius: 4px;
            border: 1px solid #ced4da;
        }

        .cantidad-dia:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.12rem rgba(0, 123, 255, .25);
        }

        .celda-con-dato {
            background: #d4edda;
            font-weight: bold;
        }

        .fila-automatica td,
        .fila-automatica .col-numero,
        .fila-automatica .col-concepto {
            background: #fff3cd !important;
            font-weight: bold;
        }

        .fila-automatica input {
            background: #fff3cd !important;
            font-weight: bold;
            cursor: not-allowed;
            border: 1px solid #e0a800;
        }

        .fila-total-dia td {
            background: #d1ecf1 !important;
            font-weight: bold;
            position: sticky;
            bottom: 0;
            z-index: 12;
        }

        .total-fila {
            background: #e2f0fb;
        }

        .tabla-atenciones tbody tr:hover td {
            background: #eef6ff;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            calcularAutomaticas();
            calcularTotales();

            $('.cantidad-dia:not([readonly])').on('input', function() {
                let valor = parseInt($(this).val()) || 0;

                if (valor > 0) {
                    $(this).addClass('celda-con-dato');
                } else {
                    $(this).removeClass('celda-con-dato');
                }

                calcularAutomaticas();
                calcularTotales();
            });

            $('.cantidad-dia:not([readonly])').on('blur', function() {
                guardarCelda($(this));
            });

            $('.cantidad-dia:not([readonly])').on('keydown', function(e) {
                let inputs = $('.cantidad-dia:not([readonly])');
                let index = inputs.index(this);

                if (e.key === 'Enter') {
                    e.preventDefault();
                    inputs.eq(index + 1).focus();
                }
            });

            function guardarCelda(input) {
                $('#estadoGuardado')
                    .removeClass('badge-info badge-success badge-danger')
                    .addClass('badge-warning')
                    .text('Guardando...');

                $.ajax({
                    url: "{{ route('atenciones-diarias.guardar-celda') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        medico_id: $('#medico_id').val(),
                        anio: parseInt($('#anio').val()),
                        mes: parseInt($('#mes').val()),
                        dia: input.data('dia'),
                        concepto_id: input.data('concepto'),
                        cantidad: input.val() || 0
                    },
                    success: function(response) {
                        if (response.automaticos) {
                            response.automaticos.forEach(function(item) {
                                let celda = $('.cantidad-dia[data-concepto="' + item
                                    .concepto_id + '"][data-dia="' + item.dia + '"]');
                                celda.val(item.cantidad);

                                if (item.cantidad > 0) {
                                    celda.addClass('celda-con-dato');
                                } else {
                                    celda.removeClass('celda-con-dato');
                                }
                            });
                        }

                        calcularAutomaticas();
                        calcularTotales();

                        $('#estadoGuardado')
                            .removeClass('badge-warning badge-danger')
                            .addClass('badge-success')
                            .text('Guardado');
                    },
                    error: function(xhr) {
                        $('#estadoGuardado')
                            .removeClass('badge-warning badge-success')
                            .addClass('badge-danger')
                            .text('Error al guardar');

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message ?? 'No se pudo guardar la celda.'
                        });
                    }
                });
            }

            function calcularAutomaticas() {
                for (let dia = 1; dia <= {{ $diasMes }}; dia++) {
                    let totalPacientes = sumarRango(dia, 1, 18);
                    setValorAutomatico(19, dia, totalPacientes);

                    let totalMenores = sumarRango(dia, 45, 50);
                    setValorAutomatico(44, dia, totalMenores);
                }
            }

            function sumarRango(dia, desde, hasta) {
                let total = 0;

                for (let orden = desde; orden <= hasta; orden++) {
                    let input = $('.cantidad-dia[data-orden="' + orden + '"][data-dia="' + dia + '"]');
                    total += parseInt(input.val()) || 0;
                }

                return total;
            }

            function setValorAutomatico(orden, dia, valor) {
                let input = $('.cantidad-dia[data-orden="' + orden + '"][data-dia="' + dia + '"]');
                input.val(valor);

                if (valor > 0) {
                    input.addClass('celda-con-dato');
                } else {
                    input.removeClass('celda-con-dato');
                }
            }

            function calcularTotales() {
                let granTotal = 0;

                $('tbody tr').each(function() {
                    let totalFila = 0;

                    $(this).find('.cantidad-dia').each(function() {
                        totalFila += parseInt($(this).val()) || 0;
                    });

                    $(this).find('.total-fila').text(totalFila);
                });

                $('.total-dia').each(function() {
                    let dia = $(this).data('dia');

                    let totalPacientes = parseInt(
                        $('.cantidad-dia[data-orden="19"][data-dia="' + dia + '"]').val()
                    ) || 0;

                    $(this).text(totalPacientes);
                    granTotal += totalPacientes;
                });

                $('#granTotal').text(granTotal);
            }

            @if ($periodo->cerrado && auth()->user()->hasRole('Medico'))

                $('.cantidad-dia').prop('readonly', true);
                $('.cantidad-dia').css({
                    'background': '#f8d7da',
                    'cursor': 'not-allowed'
                });

                $('#estadoGuardado')
                    .removeClass('badge-info')
                    .addClass('badge-danger')
                    .text('Período Cerrado');
            @endif
        });
    </script>
@stop
