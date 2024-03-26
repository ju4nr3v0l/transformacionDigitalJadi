<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class capacidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $capacidades = [
            ['nombre'=>'Planeación Estratégica','descripcion'=>'La organización tiene clara su misión, visión, propósito y los objetivos a corto, mediano y largo plazo para conseguirlos.','dimensionFk'=>1],
            ['nombre'=>'Gestión del Portafolio','descripcion'=>'La organización prioriza y gestiona las iniciativas del portafolio de iniciativas estratégicas de forma estructucturada, basados en datos y dando prioridad a las iniciativas que mas valor generan para la organización y el cliente.','dimensionFk'=>1],
            ['nombre'=>'Gestión del Producto','descripcion'=>'En la organización hay un proceso y y un rol que define el aspecto funcional de las soluciones de software que deben entregarse y lo prioriza de cara al valor que entrega al negocio y al usuario.','dimensionFk'=>1],
            ['nombre'=>'Presupuesto','descripcion'=>'La organización asigna y controla los gastos para asegurar que se invierten eficientemente.','dimensionFk'=>1],
            ['nombre'=>'Experiencia de Usuario','descripcion'=>'Las soluciones hacia el cliente final cuentan con un proceso de diseño de experiencia que incluye la investigación, diseño de prototipos y validación con usuarios reales.','dimensionFk'=>2],
            ['nombre'=>'Servicio al Cliente','descripcion'=>'La voz del cliente a través de los equipos de soporte es priorizada para la atención de problemas o mejora de las soluciones existentes.','dimensionFk'=>2],
            ['nombre'=>'Cultura','descripcion'=>'Se promueve permanentemente una cultura de trabajo colaborativo y adaptación al cambio para lograr los objetivos del negocio.','dimensionFk'=>3],
            ['nombre'=>'Habilidades y Talento','descripcion'=>'Los empleados tienen un plan de desarrollo de sus competencias para crecer con la organización.','dimensionFk'=>3],
            ['nombre'=>'Gestión de Procesos','descripcion'=>'La organización identifica, diseña, monitorea y optimiza sus procesos nuevos y existentes.','dimensionFk'=>4],
            ['nombre'=>'Operaciones','descripcion'=>'La organización tiene claramente definidos cómo atender incidentes o problemas en la tecnología que afectan la operación del negocio.','dimensionFk'=>4],
            ['nombre'=>'Arquitectura','descripcion'=>'Tecnología cuenta con la capacidad de visionar y diseñar soluciones costo eficientes que responden a las necesidades iniciales del requerimiento.','dimensionFk'=>5],
            ['nombre'=>'Tecnologías Emergentes 4.0','descripcion'=>'La organización ha adaptado tecnologías 4.0 para mejorar sus procesos o la experiencia del cliente final.','dimensionFk'=>5],
            ['nombre'=>'Infraestructura','descripcion'=>'La organización tiene la capacidad de gestionar su infraestructura tecnológica en todo el ciclo de vida, desde el desarrollo, despliegue y mantenimiento de las operaciones diarias.','dimensionFk'=>5],
            ['nombre'=>'Seguridad Cibernética','descripcion'=>'La organización ha definido claramente sus lineamientos de seguridad de la información, protección de datos y cumplimiento regulatorio.','dimensionFk'=>5],
            ['nombre'=>'DevOps','descripcion'=>'Los equipos cuentan con prácticas de integración continua y despliegue continuo de soluciones que generan valor al cliente y al negocio.','dimensionFk'=>5],
            ['nombre'=>'Gestión de la Innovación','descripcion'=>'Hay un proceso claro para identificar, apoyar, desarrollar y medir las iniciativas innovadoras.','dimensionFk'=>6],
            ['nombre'=>'Innovación Abierta','descripcion'=>'falta llenar','dimensionFk'=>6],
            ['nombre'=>'Agilidad Organizacional','descripcion'=>'La agilidad empresarial es la capacidad de una organización para adaptarse rápidamente a los cambios del mercado y las necesidades de los clientes. Se trata de una cultura de trabajo que fomenta la innovación, la colaboración y la toma rápida de decisiones.','dimensionFk'=>7],
            ['nombre'=>'Decisiones Orientadas por los Datos','descripcion'=>'La organización ha definido sus principales KPIs y los mide a través de tableros de control para tomar las decisiones estratégicas y tácticas.','dimensionFk'=>8],
            ['nombre'=>'Gobierno de Datos','descripcion'=>'La organización gestiona un modelo de datos que le permite operar eficientemente y obtener información relevante para la toma de decisiones.','dimensionFk'=>8]

        ];

        foreach ($capacidades as $capacidad) {
            \DB::table('capacidades')->insert($capacidad);
        }
    }
}
