<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
             'name' => 'Facundo Esteban',
             'surname' => 'Palermo',
             'email' => 'facundo.e.palermo@gmail.com',
             'password' => '1234',
             'dni' => 34172722,
             'address' => 'Calle Falsa 123',
             'phone' => '+5491112345678',
             'isAdmin' => true
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Usuario',
            'surname' => 'Normalito',
            'email' => 'usuario@gmail.com',
            'password' => '1234',
            'dni' => 12345678,
            'address' => 'Calle Falsa 234',
            'phone' => '+5491187654321',
            'isAdmin' => false
       ]);
    }
}