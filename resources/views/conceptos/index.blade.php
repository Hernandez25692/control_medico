@extends('adminlte::page')

@section('title', 'Conceptos')

@section('content_header')
    <h1>Catálogo de Conceptos</h1>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-header">
            <button class="btn btn-primary" id="btnNuevo">
                <i class="fas fa-plus"></i> Nuevo Concepto
            </button>
        </div>

        <div class="card-body">
            <table id="tablaConceptos" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th width="160">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($conceptos as $concepto)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $concepto->codigo }}</td>
                            <td>{{ $concepto->nombre }}</td>
                            <td>{{ $concepto->descripcion ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $concepto->activo ? 'badge-success' : 'badge-danger' }}">
                                    {{ $concepto->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning btnEditar" data-id="{{ $concepto->id }}"
                                    title="Editar concepto">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn btn-sm {{ $concepto->activo ? 'btn-danger' : 'btn-success' }} btnEstado"
                                    data-id="{{ $concepto->id }}"
                                    title="{{ $concepto->activo ? 'Inactivar concepto' : 'Activar concepto' }}">
                                    <i class="fas {{ $concepto->activo ? 'fa-ban' : 'fa-check' }}"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalConcepto" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="formConcepto">
                @csrf
                <input type="hidden" id="concepto_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Concepto</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control">
                            <small class="text-danger error-codigo"></small>
                        </div>

                        <div class="form-group">
                            <label>Nombre del concepto</label>
                            <input type="text" name="nombre" id="nombre" class="form-control">
                            <small class="text-danger error-nombre"></small>
                        </div>

                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
                            <small class="text-danger error-descripcion"></small>
                        </div>

                        <div class="form-group">
                            <label>Orden</label>
                            <input type="number" name="orden" id="orden" class="form-control" value="0">
                            <small class="text-danger error-orden"></small>
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
            $('#tablaConceptos').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
                }
            });

            $('#btnNuevo').click(function() {
                limpiarFormulario();
                $('#modalConcepto').modal('show');
            });

            $('.btnEditar').click(function() {
                limpiarFormulario();

                let id = $(this).data('id');

                $.get(`/conceptos/${id}/edit`, function(data) {
                    $('#concepto_id').val(data.id);
                    $('#codigo').val(data.codigo);
                    $('#nombre').val(data.nombre);
                    $('#descripcion').val(data.descripcion);
                    $('#orden').val(data.orden);
                    $('#activo').prop('checked', data.activo);
                    $('#modalConcepto').modal('show');
                });
            });

            $('#formConcepto').submit(function(e) {
                e.preventDefault();

                let id = $('#concepto_id').val();
                let url = id ? `/conceptos/${id}` : `{{ route('conceptos.store') }}`;
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
                    text: 'El concepto será activado o inactivado.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/conceptos/${id}/estado`,
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
                $('#formConcepto')[0].reset();
                $('#concepto_id').val('');
                $('#orden').val(0);
                $('#activo').prop('checked', true);
                limpiarErrores();
            }

            function limpiarErrores() {
                $('.text-danger').text('');
            }
        });
    </script>
@stop
