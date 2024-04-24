<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class dimensionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dimensiones = [
            ['nombre' => 'Estrategia Digital'],
            ['nombre' => 'Experiencia de Cliente'],
            ['nombre' => 'Personas y Cultura'],
            ['nombre' => 'Operaciones y Procesos'],
            ['nombre' => 'Tecnología y Arquitectura'],
            ['nombre' => 'Innovación'],
            ['nombre' => 'Agilidad Organizacional'],
            ['nombre' => 'Medición y Analítica'],
        ];

        foreach ($dimensiones as $dimension) {
            \DB::table('dimensiones')->insert($dimension);
        }
    }
}
