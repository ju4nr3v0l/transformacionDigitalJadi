<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class preguntasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preguntas = [
            ['texto'=>'¿Cómo describirías el proceso de establecimiento de objetivos digitales en tu organización?','capacidadFk'=>1],
            ['texto'=>'¿Cómo gestiona tu organización las iniciativas digitales en términos de priorización y alineación estratégica?','capacidadFk'=>2],
            ['texto'=>'¿Cómo se priorizan y definen las características de los productos digitales en tu organización?','capacidadFk'=>3],
            ['texto'=>'¿Cómo se asigna y controla el presupuesto en su estrategia digital?','capacidadFk'=>4],
            ['texto'=>'¿Cómo considera su organización el diseño de experiencia de usuario en el desarrollo de soluciones digitales?','capacidadFk'=>5],
            ['texto'=>'¿Cómo se utiliza la retroalimentación de los clientes en la mejora y atención de problemas de las soluciones existentes?','capacidadFk'=>6],
            ['texto'=>'¿De qué manera se fomenta una cultura de trabajo colaborativo y adaptación al cambio en tu organización?','capacidadFk'=>7],
            ['texto'=>'¿Cómo se estructuran y ejecutan los planes de desarrollo de competencias de los empleados?','capacidadFk'=>8],
            ['texto'=>'¿Cómo gestiona tu organización la identificación, diseño, monitoreo y optimización de procesos?','capacidadFk'=>9],
            ['texto'=>'¿Cómo se definen y manejan los incidentes o problemas tecnológicos que impactan las operaciones del negocio?','capacidadFk'=>10],
            ['texto'=>'¿Cómo se abordan la visión y el diseño de soluciones tecnológicas en tu organización?','capacidadFk'=>11],
            ['texto'=>'¿Cómo ha integrado tu organización tecnologías emergentes 4.0 para mejorar procesos o la experiencia del cliente?','capacidadFk'=>12],
            ['texto'=>'¿Cómo gestiona tu organización el ciclo de vida completo de su infraestructura tecnológica?','capacidadFk'=>13],
            ['texto'=>'¿Cómo define y aplica tu organización las normativas de seguridad de la información y protección de datos?','capacidadFk'=>14],
            ['texto'=>'¿En qué medida se han implementado las prácticas de integración y despliegue continuo en los equipos de tu organización?','capacidadFk'=>15],
            ['texto'=>'¿Cómo se maneja el proceso de innovación dentro de tu organización?','capacidadFk'=>16],
            ['texto'=>'¿Cómo incorpora tu organización conceptos de innovación abierta para mejorar sus procesos y productos?','capacidadFk'=>17],
            ['texto'=>'¿Cómo describirías la agilidad organizacional en tu empresa?','capacidadFk'=>18],
            ['texto'=>'¿Cómo se utilizan los datos y KPIs en la toma de decisiones dentro de tu organización?','capacidadFk'=>19],
            ['texto'=>'¿Cómo gestiona tu organización su modelo de datos para la toma de decisiones?','capacidadFk'=>20],

        ];

        foreach ($preguntas as $pregunta) {
            \DB::table('preguntas')->insert($pregunta);
        }
    }
}
