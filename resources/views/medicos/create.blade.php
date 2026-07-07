@extends('adminlte::page')

@section('title', 'Nuevo Médico')

@section('content_header')
    <h1>Nuevo Médico</h1>
@stop

@section('content')

    <div class="card">
        <form action="{{ route('medicos.store') }}" method="POST">
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label>Código</label>
                    <input type="text" name="codigo" class="form-control" value="{{ old('codigo') }}" required>
                    @error('codigo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nombre del médico</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Especialidad</label>
                    <input type="text" name="especialidad" class="form-control" value="{{ old('especialidad') }}">
                </div>

                <div class="form-check">
                    <input type="checkbox" name="activo" class="form-check-input" checked>
                    <label class="form-check-label">Activo</label>
                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-primary">Guardar</button>
                <a href="{{ route('medicos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

@stop
