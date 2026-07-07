<?php

namespace App\Http\Controllers;

use App\Models\Concepto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConceptoController extends Controller
{
    public function index()
    {
        $conceptos = Concepto::orderBy('orden')->orderBy('nombre')->get();

        return view('conceptos.index', compact('conceptos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => ['required', 'string', 'max:20', 'unique:conceptos,codigo'],
            'nombre' => ['required', 'string', 'max:200', 'unique:conceptos,nombre'],
            'descripcion' => ['nullable', 'string'],
            'orden' => ['nullable', 'integer', 'min:0'],
        ]);

        Concepto::create([
            'codigo' => strtoupper(trim($request->codigo)),
            'nombre' => trim($request->nombre),
            'descripcion' => $request->descripcion,
            'orden' => $request->orden ?? 0,
            'activo' => $request->has('activo'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Concepto registrado correctamente.',
        ]);
    }

    public function edit(Concepto $concepto)
    {
        return response()->json($concepto);
    }

    public function update(Request $request, Concepto $concepto)
    {
        $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:20',
                Rule::unique('conceptos', 'codigo')->ignore($concepto->id),
            ],
            'nombre' => [
                'required',
                'string',
                'max:200',
                Rule::unique('conceptos', 'nombre')->ignore($concepto->id),
            ],
            'descripcion' => ['nullable', 'string'],
            'orden' => ['nullable', 'integer', 'min:0'],
        ]);

        $concepto->update([
            'codigo' => strtoupper(trim($request->codigo)),
            'nombre' => trim($request->nombre),
            'descripcion' => $request->descripcion,
            'orden' => $request->orden ?? 0,
            'activo' => $request->has('activo'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Concepto actualizado correctamente.',
        ]);
    }

    public function cambiarEstado(Concepto $concepto)
    {
        $concepto->update([
            'activo' => !$concepto->activo,
        ]);

        return response()->json([
            'success' => true,
            'message' => $concepto->activo
                ? 'Concepto activado correctamente.'
                : 'Concepto inactivado correctamente.',
        ]);
    }
}
