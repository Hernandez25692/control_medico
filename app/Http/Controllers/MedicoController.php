<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MedicoController extends Controller
{
    public function index()
    {
        $medicos = Medico::orderBy('nombre')->get();

        return view('medicos.index', compact('medicos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => ['required', 'string', 'max:20', 'unique:medicos,codigo'],
            'nombre' => ['required', 'string', 'max:150', 'unique:medicos,nombre'],
            'especialidad' => ['nullable', 'string', 'max:100'],
        ]);

        Medico::create([
            'codigo' => strtoupper(trim($request->codigo)),
            'nombre' => trim($request->nombre),
            'especialidad' => $request->especialidad,
            'activo' => $request->has('activo'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Médico registrado correctamente.',
        ]);
    }

    public function edit(Medico $medico)
    {
        return response()->json($medico);
    }

    public function update(Request $request, Medico $medico)
    {
        $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:20',
                Rule::unique('medicos', 'codigo')->ignore($medico->id),
            ],
            'nombre' => [
                'required',
                'string',
                'max:150',
                Rule::unique('medicos', 'nombre')->ignore($medico->id),
            ],
            'especialidad' => ['nullable', 'string', 'max:100'],
        ]);

        $medico->update([
            'codigo' => strtoupper(trim($request->codigo)),
            'nombre' => trim($request->nombre),
            'especialidad' => $request->especialidad,
            'activo' => $request->has('activo'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Médico actualizado correctamente.',
        ]);
    }

    public function cambiarEstado(Medico $medico)
    {
        $medico->update([
            'activo' => !$medico->activo,
        ]);

        return response()->json([
            'success' => true,
            'message' => $medico->activo
                ? 'Médico activado correctamente.'
                : 'Médico inactivado correctamente.',
        ]);
    }
}
