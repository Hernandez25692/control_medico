<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permisos = [

            'dashboard',

            'usuarios.ver',
            'usuarios.crear',
            'usuarios.editar',
            'usuarios.eliminar',

            'medicos.ver',
            'medicos.crear',
            'medicos.editar',
            'medicos.eliminar',

            'conceptos.ver',
            'conceptos.crear',
            'conceptos.editar',
            'conceptos.eliminar',

            'atenciones.ver',
            'atenciones.crear',
            'atenciones.editar',
            'atenciones.eliminar',

            'reportes.ver',
            'graficas.ver',
            'configuracion'
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        $admin = Role::firstOrCreate(['name' => 'Administrador']);

        $admin->syncPermissions(Permission::all());
    }
}
