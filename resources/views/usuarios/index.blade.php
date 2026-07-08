@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Administración de Usuarios</h1>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-header">
            <button class="btn btn-primary" id="btnNuevo">
                <i class="fas fa-plus"></i> Nuevo Usuario
            </button>
        </div>

        <div class="card-body">
            <table id="tablaUsuarios" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Médico</th>
                        <th>Estado</th>
                        <th width="160">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->roles->first()?->name ?? 'Sin rol' }}</td>
                            <td>{{ $usuario->medico->nombre ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $usuario->activo ? 'badge-success' : 'badge-danger' }}">
                                    {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning btnEditar" data-id="{{ $usuario->id }}"
                                    title="Editar usuario">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn btn-sm {{ $usuario->activo ? 'btn-danger' : 'btn-success' }} btnEstado"
                                    data-id="{{ $usuario->id }}"
                                    title="{{ $usuario->activo ? 'Inhabilitar usuario' : 'Activar usuario' }}">
                                    <i class="fas {{ $usuario->activo ? 'fa-ban' : 'fa-check' }}"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalUsuario" tabindex="-1">
        <div class="modal-dialog">
            <form id="formUsuario">
                @csrf
                <input type="hidden" id="usuario_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Usuario</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="name" id="name" class="form-control">
                            <small class="text-danger error-name"></small>
                        </div>

                        <div class="form-group">
                            <label>Correo</label>
                            <input type="email" name="email" id="email" class="form-control">
                            <small class="text-danger error-email"></small>
                        </div>

                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <small class="text-muted">En edición puede quedar vacía.</small>
                            <br>
                            <small class="text-danger error-password"></small>
                        </div>

                        <div class="form-group">
                            <label>Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Rol</label>
                            <select name="rol" id="rol" class="form-control">
                                <option value="Administrador">Administrador</option>
                                <option value="Medico">Médico</option>
                            </select>
                            <small class="text-danger error-rol"></small>
                        </div>

                        <div class="form-group" id="grupoMedico" style="display:none;">
                            <label>Médico asociado</label>
                            <select name="medico_id" id="medico_id" class="form-control">
                                <option value="">Seleccione un médico</option>
                                @foreach ($medicos as $medico)
                                    <option value="{{ $medico->id }}">
                                        {{ $medico->codigo }} - {{ $medico->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-danger error-medico_id"></small>
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
            $('#tablaUsuarios').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
                }
            });

            $('#btnNuevo').click(function() {
                limpiarFormulario();
                $('#modalUsuario').modal('show');
            });

            $('#rol').change(function() {
                mostrarMedico();
            });

            $('.btnEditar').click(function() {
                limpiarFormulario();

                let id = $(this).data('id');

                $.get(`/usuarios/${id}/edit`, function(data) {
                    $('#usuario_id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#rol').val(data.rol);
                    $('#activo').prop('checked', data.activo);

                    if (data.medico_id) {
                        if ($('#medico_id option[value="' + data.medico_id + '"]').length === 0) {
                            $('#medico_id').append(
                                `<option value="${data.medico_id}">Médico actual</option>`
                            );
                        }

                        $('#medico_id').val(data.medico_id);
                    }

                    mostrarMedico();
                    $('#modalUsuario').modal('show');
                });
            });

            $('#formUsuario').submit(function(e) {
                e.preventDefault();

                let id = $('#usuario_id').val();
                let url = id ? `/usuarios/${id}` : `{{ route('usuarios.store') }}`;
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
                    text: 'El usuario será activado o inhabilitado.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/usuarios/${id}/estado`,
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

            function mostrarMedico() {
                if ($('#rol').val() === 'Medico') {
                    $('#grupoMedico').show();
                } else {
                    $('#grupoMedico').hide();
                    $('#medico_id').val('');
                }
            }

            function limpiarFormulario() {
                $('#formUsuario')[0].reset();
                $('#usuario_id').val('');
                $('#activo').prop('checked', true);
                $('#grupoMedico').hide();
                limpiarErrores();
            }

            function limpiarErrores() {
                $('.text-danger').text('');
            }
        });
    </script>
@stop
