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
        $codigoSugerido = Medico::generarCodigoAutomatico();

        return view('medicos.index', compact('medicos', 'codigoSugerido'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:150',
                Rule::unique('medicos', 'nombre'),
            ],
            'especialidad' => 'nullable|string|max:100',
        ]);

        Medico::create([
            'codigo' => Medico::generarCodigoAutomatico(),
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
            'nombre' => [
                'required',
                'string',
                'max:150',
                Rule::unique('medicos', 'nombre')->ignore($medico->id),
            ],
            'especialidad' => ['nullable', 'string', 'max:100'],
        ]);

        $medico->update([
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

    public function create()
    {
        $codigoSugerido = Medico::generarCodigoAutomatico();

        return view('medicos.create', compact('codigoSugerido'));
    }
}
