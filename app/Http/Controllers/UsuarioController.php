<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with(['medico', 'roles'])->orderBy('name')->get();

        $medicos = Medico::where('activo', true)
            ->whereDoesntHave('usuarios')
            ->orderBy('nombre')
            ->get();

        return view('usuarios.index', compact('usuarios', 'medicos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'rol' => ['required', Rule::in(['Administrador', 'Medico'])],
            'medico_id' => ['nullable', 'exists:medicos,id'],
        ]);

        if ($request->rol === 'Medico' && !$request->medico_id) {
            return response()->json([
                'errors' => ['medico_id' => ['Debe seleccionar un médico.']]
            ], 422);
        }

        $usuario = User::create([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'password' => Hash::make($request->password),
            'medico_id' => $request->rol === 'Medico' ? $request->medico_id : null,
            'activo' => $request->has('activo'),
        ]);

        $usuario->syncRoles([$request->rol]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario registrado correctamente.',
        ]);
    }

    public function edit(User $usuario)
    {
        return response()->json([
            'id' => $usuario->id,
            'name' => $usuario->name,
            'email' => $usuario->email,
            'medico_id' => $usuario->medico_id,
            'activo' => $usuario->activo,
            'rol' => $usuario->roles->first()?->name,
        ]);
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($usuario->id),
            ],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'rol' => ['required', Rule::in(['Administrador', 'Medico'])],
            'medico_id' => ['nullable', 'exists:medicos,id'],
        ]);

        if ($request->rol === 'Medico' && !$request->medico_id) {
            return response()->json([
                'errors' => ['medico_id' => ['Debe seleccionar un médico.']]
            ], 422);
        }

        $data = [
            'name' => trim($request->name),
            'email' => trim($request->email),
            'medico_id' => $request->rol === 'Medico' ? $request->medico_id : null,
            'activo' => $request->has('activo'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);
        $usuario->syncRoles([$request->rol]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente.',
        ]);
    }

    public function cambiarEstado(User $user)
    {
        $user->update([
            'activo' => !$user->activo,
        ]);

        return response()->json([
            'success' => true,
            'message' => $user->activo
                ? 'Usuario activado correctamente.'
                : 'Usuario inhabilitado correctamente.',
        ]);
    }
}
