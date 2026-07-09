@extends('adminlte::page')

@section('title', 'Atenciones Diarias')

@section('content_header')
    <h1>Registro Diario de Atenciones Médicas</h1>
@stop

@section('content')

    <div class="card shadow-sm clinic-sheet-card">
        @if ($periodo->cerrado)
            <div class="alert alert-danger mb-3 d-flex align-items-center gap-2">
                <i class="fas fa-lock"></i>
                <div>
                    <strong>Período Cerrado.</strong>

                    @if (auth()->user()->hasRole('Administrador'))
                        Solo el administrador puede realizar modificaciones.
                    @else
                        No es posible editar registros de este período.
                    @endif
                </div>
            </div>
        @else
            <div class="alert alert-success mb-3 d-flex align-items-center gap-2">
                <i class="fas fa-lock-open"></i>
                <div>
                    <strong>Período Abierto.</strong>
                    Los registros pueden modificarse.
                </div>
            </div>
        @endif

        <div class="card-header bg-white sheet-toolbar">
            <form method="GET" action="{{ route('atenciones-diarias.index') }}" class="row align-items-end">

                @if (auth()->user()->hasRole('Administrador'))
                    <div class="col-md-4 toolbar-field">
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
                    <div class="col-md-4 toolbar-field">
                        <label>Médico</label>
                        <input type="text" class="form-control"
                            value="{{ auth()->user()->medico->codigo }} - {{ auth()->user()->medico->nombre }}" readonly>
                    </div>
                @endif

                <div class="col-md-3 toolbar-field">
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

                <div class="col-md-2 toolbar-field">
                    <label>Año</label>
                    <input type="number" name="anio" class="form-control" value="{{ $anio }}">
                </div>

                <div class="col-md-3 toolbar-field">
                    <button class="btn btn-primary btn-block">
                        <i class="fas fa-search"></i> Consultar
                    </button>
                </div>

            </form>
        </div>

        <div class="card-body">

            <div class="sheet-status-row mb-2">
                <span class="badge badge-success"><i class="fas fa-save"></i> Autoguardado activo</span>
                <span class="badge badge-warning"><i class="fas fa-lock"></i> Filas automáticas bloqueadas</span>
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
                            <th class="col-concepto text-left">Concepto</th>

                            @for ($dia = 1; $dia <= $diasMes; $dia++)
                                @php
                                    $esFinDeSemana = \Carbon\Carbon::createFromDate(
                                        (int) $anio,
                                        (int) $mes,
                                        $dia,
                                    )->isWeekend();
                                @endphp
                                <th class="col-dia {{ $esFinDeSemana ? 'col-dia-weekend' : '' }}">{{ $dia }}</th>
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
                                        $esFinDeSemana = \Carbon\Carbon::createFromDate(
                                            (int) $anio,
                                            (int) $mes,
                                            $dia,
                                        )->isWeekend();
                                    @endphp

                                    <td class="{{ $esFinDeSemana ? 'col-dia-weekend' : '' }}">
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
            --amber-border: #F0C36D;
            --weekend-tint: #F2F5F9;
            --ink: #16232E;
            --muted: #6B7A88;
            --grid-line: #DCE4EA;
            --total-tint: #EAF1F7;
        }

        /* ---------- Tarjeta y encabezado ---------- */

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

        /* ---------- Badges de estado ---------- */

        .sheet-status-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .sheet-status-row .badge {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 600;
            padding: 7px 12px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            letter-spacing: 0.01em;
        }

        /* ---------- Contenedor / hoja de cálculo ---------- */

        .contenedor-tabla {
            max-height: 680px;
            overflow: auto;
            border: 1px solid var(--grid-line);
            border-radius: 10px;
            background: #fff;
        }

        .tabla-atenciones {
            margin-bottom: 0;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13.5px;
            border-collapse: separate;
            border-spacing: 0;
        }

        .tabla-atenciones th,
        .tabla-atenciones td {
            border: 1px solid var(--grid-line) !important;
            vertical-align: middle;
            white-space: nowrap;
        }

        /* Encabezado tipo Excel */
        .tabla-atenciones thead th {
            background: var(--navy);
            color: #fff;
            text-align: center;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 12.5px;
            letter-spacing: 0.02em;
            padding: 12px 8px;
            position: sticky;
            top: 0;
            z-index: 10;
            border-color: var(--navy-dark) !important;
        }

        .tabla-atenciones thead .col-dia-weekend {
            background: var(--navy-dark);
        }

        /* Columnas congeladas (freeze panes) */
        .col-numero {
            min-width: 60px;
            width: 60px;
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
            width: 420px;
            position: sticky;
            left: 60px;
            background: #ffffff;
            z-index: 8;
            font-family: 'Inter', sans-serif;
            font-size: 13.5px;
            padding-left: 14px !important;
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
            padding-left: 14px !important;
        }

        /* Celdas de día — más grandes, estilo Excel */
        .col-dia {
            min-width: 68px;
            padding: 0 !important;
        }

        .col-dia-weekend {
            background: var(--weekend-tint);
        }

        .col-total {
            min-width: 95px;
            background: var(--total-tint) !important;
            color: var(--navy);
        }

        /* Inputs de cantidad — celdas grandes */
        .cantidad-dia {
            height: 46px;
            width: 100%;
            border: none;
            border-radius: 0;
            background: transparent;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 14.5px;
            font-weight: 600;
            color: var(--ink);
            text-align: center;
            padding: 0;
        }

        .cantidad-dia:focus {
            outline: none;
            background: #fff;
            box-shadow: inset 0 0 0 2px var(--teal);
            position: relative;
            z-index: 5;
        }

        .celda-con-dato {
            background: var(--teal-tint);
            color: #146455;
        }

        .cantidad-dia:focus.celda-con-dato {
            background: #fff;
        }

        /* Filas automáticas (calculadas / bloqueadas) */
        .fila-automatica td,
        .fila-automatica .col-numero,
        .fila-automatica .col-concepto {
            background: var(--amber-tint) !important;
        }

        .fila-automatica .col-numero,
        .fila-automatica .col-concepto {
            color: var(--amber);
        }

        .fila-automatica input {
            background: var(--amber-tint) !important;
            color: var(--amber);
            font-weight: 700;
            cursor: not-allowed;
        }

        /* Totales */
        .fila-total-dia td {
            background: var(--navy) !important;
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 12.5px;
            position: sticky;
            bottom: 0;
            z-index: 12;
            padding: 12px 8px;
        }

        .fila-total-dia .col-numero,
        .fila-total-dia .col-concepto {
            background: var(--navy-dark) !important;
            color: #fff;
            text-align: left;
        }

        #granTotal {
            background: var(--teal) !important;
        }

        .total-fila {
            background: var(--total-tint);
            color: var(--navy);
            font-family: 'Inter', sans-serif;
        }

        /* Hover tipo hoja de cálculo */
        .tabla-atenciones tbody tr:hover td:not(.col-numero):not(.col-concepto) {
            background: #F0F7FC;
        }

        .tabla-atenciones tbody tr:hover .col-numero,
        .tabla-atenciones tbody tr:hover .col-concepto {
            background: #E7EFF4;
        }

        .tabla-atenciones tbody tr.fila-automatica:hover td {
            background: var(--amber-tint) !important;
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
