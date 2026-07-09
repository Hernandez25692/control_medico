@extends('adminlte::page')

@section('title', 'Médicos')

@section('content_header')
    <h1>Catálogo de Médicos</h1>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-header">
            <button class="btn btn-primary" id="btnNuevo">
                <i class="fas fa-plus"></i> Nuevo Médico
            </button>
        </div>

        <div class="card-body">
            <table id="tablaMedicos" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Especialidad</th>
                        <th>Estado</th>
                        <th width="160">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($medicos as $medico)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $medico->codigo }}</td>
                            <td>{{ $medico->nombre }}</td>
                            <td>{{ $medico->especialidad ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $medico->activo ? 'badge-success' : 'badge-danger' }}">
                                    {{ $medico->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning btnEditar" data-id="{{ $medico->id }}"
                                    title="Editar médico">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn btn-sm {{ $medico->activo ? 'btn-danger' : 'btn-success' }} btnEstado"
                                    data-id="{{ $medico->id }}"
                                    title="{{ $medico->activo ? 'Inactivar médico' : 'Activar médico' }}">
                                    <i class="fas {{ $medico->activo ? 'fa-ban' : 'fa-check' }}"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalMedico" tabindex="-1">
        <div class="modal-dialog">
            <form id="formMedico">
                @csrf
                <input type="hidden" id="medico_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Médico</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Código</label>

                            <input type="text" id="codigo" class="form-control bg-light text-muted"
                                value="{{ $codigoSugerido ?? 'Se generará automáticamente' }}" readonly tabindex="-1"
                                style="cursor: not-allowed;">

                            <small class="text-muted">
                                El código será asignado automáticamente al guardar el médico.
                            </small>
                        </div>

                        <div class="form-group">
                            <label>Nombre del médico</label>
                            <input type="text" name="nombre" id="nombre" class="form-control">
                            <small class="text-danger error-nombre"></small>
                        </div>

                        <div class="form-group">
                            <label>Especialidad</label>
                            <input type="text" name="especialidad" id="especialidad" class="form-control">
                            <small class="text-danger error-especialidad"></small>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" name="activo" id="activo" class="form-check-input" value="1"
                                checked>
                            <label class="form-check-label">Activo</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancelar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(function() {
            $('#tablaMedicos').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
                }
            });

            $('#btnNuevo').click(function() {
                limpiarFormulario();
                $('#modalMedico').modal('show');
            });

            $('.btnEditar').click(function() {
                limpiarFormulario();

                let id = $(this).data('id');

                $.get(`/medicos/${id}/edit`, function(data) {
                    $('#medico_id').val(data.id);
                    $('#codigo').val(data.codigo);
                    $('#nombre').val(data.nombre);
                    $('#especialidad').val(data.especialidad);
                    $('#activo').prop('checked', data.activo);
                    $('#modalMedico').modal('show');
                });
            });

            $('#formMedico').submit(function(e) {
                e.preventDefault();

                let id = $('#medico_id').val();
                let url = id ? `/medicos/${id}` : `{{ route('medicos.store') }}`;
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    method: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Correcto',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(() => location.reload(), 900);
                    },
                    error: function(xhr) {
                        limpiarErrores();

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, value) {
                                $('.error-' + key).text(value[0]);
                            });
                        }
                    }
                });
            });

            $('.btnEstado').click(function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: '¿Cambiar estado?',
                    text: 'El médico será activado o inactivado.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/medicos/${id}/estado`,
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

            function limpiarFormulario() {
                $('#formMedico')[0].reset();
                $('#medico_id').val('');
                $('#codigo').val('{{ $codigoSugerido ?? 'Se generará automáticamente' }}');
                $('#activo').prop('checked', true);
                limpiarErrores();
            }

            function limpiarErrores() {
                $('.text-danger').text('');
            }
        });
    </script>
@stop
