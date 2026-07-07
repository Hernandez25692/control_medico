<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call([
            ConceptoSeeder::class,
        ]);

        $user = \App\Models\User::firstOrCreate(
            ['email' => 'admin@ccisur.org'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('Admin123*'),
            ]
        );

        $user->assignRole('Administrador');
    }
}
