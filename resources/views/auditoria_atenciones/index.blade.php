@extends('adminlte::page')

@section('title', 'Auditoría de Atenciones')

@section('content_header')
    <h1>Auditoría de Atenciones</h1>
@stop

@section('content')

    <div class="card">

        <div class="card-header bg-white">

            <form class="row">

                <div class="col-md-4">
                    <label>Médico</label>

                    <select name="medico_id" class="form-control">

                        <option value="">Todos</option>

                        @foreach ($medicos as $medico)
                            <option value="{{ $medico->id }}" {{ request('medico_id') == $medico->id ? 'selected' : '' }}>

                                {{ $medico->nombre }}

                            </option>
                        @endforeach

                    </select>

                </div>

                <div class="col-md-3">

                    <label>Fecha</label>

                    <input type="date" name="fecha" value="{{ request('fecha') }}" class="form-control">

                </div>

                <div class="col-md-3 d-flex align-items-end">

                    <button class="btn btn-primary">

                        <i class="fas fa-search"></i>

                        Consultar

                    </button>

                </div>

            </form>

        </div>

        <div class="card-body p-0">

            <table class="table table-hover table-striped">

                <thead>

                    <tr>

                        <th>Fecha/Hora</th>

                        <th>Usuario</th>

                        <th>Médico</th>

                        <th>Concepto</th>

                        <th>Día</th>

                        <th>Anterior</th>

                        <th>Nuevo</th>

                        <th>IP</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($auditorias as $item)
                        <tr>

                            <td>

                                {{ $item->created_at->format('d/m/Y H:i') }}

                            </td>

                            <td>

                                {{ $item->usuario->name ?? 'N/A' }}

                            </td>

                            <td>

                                {{ $item->medico->nombre }}

                            </td>

                            <td>

                                {{ $item->concepto->orden }}

                                -

                                {{ $item->concepto->nombre }}

                            </td>

                            <td>

                                {{ $item->fecha->format('d/m/Y') }}

                            </td>

                            <td>

                                <span class="badge badge-danger">

                                    {{ $item->valor_anterior }}

                                </span>

                            </td>

                            <td>

                                <span class="badge badge-success">

                                    {{ $item->valor_nuevo }}

                                </span>

                            </td>

                            <td>

                                {{ $item->ip }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="text-center">

                                No existen registros.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="card-footer">

            {{ $auditorias->links() }}

        </div>

    </div>

@stop
