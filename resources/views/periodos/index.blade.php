@extends('adminlte::page')

@section('title', 'Control de Períodos')

@section('content_header')
    <h1>Control de Períodos</h1>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <form method="GET" action="{{ route('periodos.index') }}" class="row">
                <div class="col-md-3">
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
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Mes</th>
                        <th>Estado</th>
                        <th>Cerrado por</th>
                        <th>Fecha de cierre</th>
                        <th width="160">Acción</th>
                    </tr>
                </thead>

                <tbody>
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

                    @foreach ($periodos as $periodo)
                        <tr>
                            <td>{{ $meses[$periodo->mes] }}</td>

                            <td>
                                <span class="badge {{ $periodo->cerrado ? 'badge-danger' : 'badge-success' }}">
                                    {{ $periodo->cerrado ? 'Cerrado' : 'Abierto' }}
                                </span>
                            </td>

                            <td>{{ $periodo->usuarioCierre->name ?? 'N/A' }}</td>

                            <td>
                                {{ $periodo->cerrado_en ? $periodo->cerrado_en->format('d/m/Y H:i') : 'N/A' }}
                            </td>

                            <td>
                                <button class="btn btn-sm {{ $periodo->cerrado ? 'btn-success' : 'btn-danger' }} btnEstado"
                                    data-id="{{ $periodo->id }}" data-cerrado="{{ $periodo->cerrado ? 1 : 0 }}">
                                    <i class="fas {{ $periodo->cerrado ? 'fa-lock-open' : 'fa-lock' }}"></i>
                                    {{ $periodo->cerrado ? 'Reabrir' : 'Cerrar' }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            $('.btnEstado').click(function() {
                let id = $(this).data('id');
                let cerrado = $(this).data('cerrado');

                Swal.fire({
                    title: cerrado ? '¿Reabrir período?' : '¿Cerrar período?',
                    text: cerrado ?
                        'Los médicos podrán editar nuevamente este mes.' :
                        'Los médicos ya no podrán editar este mes.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/periodos/${id}/estado`,
                            method: 'PATCH',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Correcto',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                setTimeout(() => location.reload(), 900);
                            }
                        });
                    }
                });
            });
        });
    </script>
@stop
