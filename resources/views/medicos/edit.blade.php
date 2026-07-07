@extends('adminlte::page')

@section('title', 'Editar Médico')

@section('content_header')
    <h1>Editar Médico</h1>
@stop

@section('content')

    <div class="card">
        <form action="{{ route('medicos.update', $medico) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label>Código</label>
                    <input type="text" name="codigo" class="form-control" value="{{ old('codigo', $medico->codigo) }}"
                        required>
                    @error('codigo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nombre del médico</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $medico->nombre) }}"
                        required>
                    @error('nombre')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Especialidad</label>
                    <input type="text" name="especialidad" class="form-control"
                        value="{{ old('especialidad', $medico->especialidad) }}">
                </div>

                <div class="form-check">
                    <input type="checkbox" name="activo" class="form-check-input" {{ $medico->activo ? 'checked' : '' }}>
                    <label class="form-check-label">Activo</label>
                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-primary">Actualizar</button>
                <a href="{{ route('medicos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

@stop
