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
            ['email' => 'gustavoavelar5019@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('Gustavo2026@#'),
            ]
        );

        $user->assignRole('Administrador');
    }
}
