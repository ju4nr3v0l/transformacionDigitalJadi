<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class respuestasPreguntasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $respuestasPreguntas = [
            ['texto'=>'No tenemos establecidos objetivos claros a corto ni largo plazo para nuestra transformación digital.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'1'],
            ['texto'=>'Tenemos algunos objetivos definidos, pero no están completamente alineados con nuestra estrategia digital general ni comunicados eficazmente.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'1'],
            ['texto'=>'Contamos con objetivos claros y bien comunicados que guían nuestra estrategia digital y están alineados con nuestra visión a largo plazo.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'1'],
            ['texto'=>'No tenemos un proceso estructurado para priorizar o alinear nuestras iniciativas digitales con la estrategia de negocio.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'2'],
            ['texto'=>'Priorizamos iniciativas, pero la alineación con la estrategia de negocio podría mejorar.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'2'],
            ['texto'=>'Gestionamos y priorizamos el portafolio de iniciativas digitales efectivamente, asegurando su alineación con la estrategia de negocio.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'2'],
            ['texto'=>'No contamos con un proceso definido ni un rol específico para la gestión del producto.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'3'],
            ['texto'=>'Tenemos un rol de gestión de producto, pero la priorización y definición de características podrían ser más efectivas.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'3'],
            ['texto'=>'Existe un rol claro de gestión del producto con procesos efectivos para priorizar y definir características basadas en investigación y análisis de mercado.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'3'],
            ['texto'=>'Realizamos estimaciones generales sin un seguimiento detallado de los gastos en proyectos digitales.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'4'],
            ['texto'=>'Asignamos presupuestos basados en estimaciones, con algunos esfuerzos de seguimiento.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'4'],
            ['texto'=>'Contamos con un sistema detallado de asignación y seguimiento de presupuesto para proyectos digitales, lo que permite ajustes y optimización continua.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'4'],
            ['texto'=>'No contamos con un proceso estructurado de diseño de experiencia de usuario.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'5'],
            ['texto'=>'Integramos aspectos de experiencia de usuario, pero de manera no sistemática o inconsistente.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'5'],
            ['texto'=>'Tenemos un proceso sistemático y continuo que integra investigación y diseño de experiencia de usuario en todas las etapas de desarrollo de soluciones digitales.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'5'],
            ['texto'=>'La voz del cliente rara vez es tomada en cuenta para la resolución de problemas o mejora de soluciones.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'6'],
            ['texto'=>'Tomamos en cuenta la voz del cliente ocasionalmente, pero no hay un proceso sistemático para integrarla en la mejora continua.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'6'],
            ['texto'=>'Tenemos un proceso bien establecido que prioriza y actúa sistemáticamente sobre la retroalimentación del cliente para la resolución de problemas y mejora de soluciones.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'6'],
            ['texto'=>'No hay iniciativas específicas que promuevan una cultura colaborativa y de adaptación al cambio.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'7'],
            ['texto'=>'Existen algunas iniciativas para fomentar la colaboración y adaptación al cambio, pero no están plenamente integradas en la cultura organizacional.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'7'],
            ['texto'=>'La cultura de trabajo colaborativo y adaptación al cambio es una constante en nuestra organización, con políticas y prácticas establecidas que la refuerzan.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'7'],
            ['texto'=>'No tenemos un plan de desarrollo estructurado para las competencias de los empleados.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'8'],
            ['texto'=>'Contamos con planes de desarrollo de competencias, pero la ejecución es irregular y no cubre a todos los empleados.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'8'],
            ['texto'=>'Todos los empleados tienen planes de desarrollo de competencias bien definidos y alineados con el crecimiento de la organización.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'8'],
            ['texto'=>'Los procesos se gestionan de manera ad hoc, sin una identificación y optimización sistemática.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'9'],
            ['texto'=>'Tenemos procesos identificados y documentados, pero el monitoreo y la optimización no son continuos.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'9'],
            ['texto'=>'La organización tiene una gestión de procesos madura, donde se identifican, diseñan, monitorean y optimizan de manera sistemática y continua.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'9'],
            ['texto'=>'La respuesta a incidentes tecnológicos es reactiva y no está claramente definida.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'10'],
            ['texto'=>'Existen algunos procedimientos para manejar incidentes tecnológicos, pero la definición y ejecución pueden mejorar.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'10'],
            ['texto'=>'Contamos con procedimientos claros y eficaces para el manejo de incidentes tecnológicos, asegurando un impacto mínimo en las operaciones del negocio.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'10'],
            ['texto'=>'Las soluciones tecnológicas se diseñan sin un enfoque claro en la eficiencia de costos o las necesidades iniciales.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'11'],
            ['texto'=>'Existe una visión de diseño de soluciones que a veces considera la eficiencia de costos y las necesidades, pero no de forma consistente.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'11'],
            ['texto'=>'La tecnología está orientada a diseñar soluciones que son costo-eficientes y alineadas con las necesidades iniciales de manera sistemática.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'11'],
            ['texto'=>'No hemos adoptado tecnologías 4.0 o su adopción no ha impactado significativamente nuestros procesos o la experiencia del cliente.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'12'],
            ['texto'=>'Hemos comenzado a explorar tecnologías emergentes 4.0 y estamos en proceso de integrarlas para mejorar procesos o la experiencia del cliente.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'12'],
            ['texto'=>'Hemos adaptado con éxito tecnologías 4.0 que mejoran sustancialmente nuestros procesos y enriquecen la experiencia del cliente.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'12'],
            ['texto'=>'La gestión de la infraestructura tecnológica es reactiva y no cubre adecuadamente todo el ciclo de vida.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'13'],
            ['texto'=>'Gestionamos nuestra infraestructura con cierto nivel de eficiencia, pero la visión de ciclo de vida completo necesita mejorar.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'13'],
            ['texto'=>'Tenemos una gestión proactiva y eficiente de la infraestructura tecnológica en todo su ciclo de vida, desde el desarrollo hasta el mantenimiento.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'13'],
            ['texto'=>'Nuestras políticas de seguridad cibernética son básicas o no están completamente definidas.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'14'],
            ['texto'=>'Tenemos lineamientos de seguridad cibernética definidos, pero su implementación y cumplimiento podrían mejorar.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'14'],
            ['texto'=>'Contamos con lineamientos claros y efectivos de seguridad cibernética, protección de datos y cumplimiento regulatorio, integrados en todas las operaciones.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'14'],
            ['texto'=>'Las prácticas de integración y despliegue continuo son inexistentes o se utilizan de manera aislada. No sé que es devops, despliegue continuo o integración continua.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'15'],
            ['texto'=>'Estamos implementando prácticas de integración y despliegue continuo, pero aún no son consistentes en todos los equipos.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'15'],
            ['texto'=>'Los equipos aplican prácticas de integración y despliegue continuo de manera efectiva, mejorando constantemente el valor que ofrecemos a clientes y al negocio.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'15'],
            ['texto'=>'No tenemos un proceso estructurado para manejar la innovación; las iniciativas innovadoras ocurren de manera esporádica y no son medidas efectivamente.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'16'],
            ['texto'=>'Contamos con un proceso para identificar y desarrollar iniciativas innovadoras, pero podríamos mejorar en su apoyo y medición.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'16'],
            ['texto'=>'Tenemos un proceso claro y bien establecido que identifica, apoya, desarrolla y mide efectivamente las iniciativas innovadoras.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'16'],
            ['texto'=>'Apenas estamos explorando qué significa innovación abierta y no la hemos incorporado en nuestros procesos.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'17'],
            ['texto'=>'Hemos comenzado a experimentar con la innovación abierta, colaborando esporádicamente con agentes externos.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'17'],
            ['texto'=>'La innovación abierta es una parte integral de nuestra estrategia de innovación, colaborando constantemente con una red de socios, clientes y comunidades','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'17'],
            ['texto'=>'Nuestra capacidad para adaptarnos rápidamente a los cambios del mercado y las necesidades de los clientes es limitada.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'18'],
            ['texto'=>'Somos relativamente ágiles y buscamos mejorar nuestra capacidad de innovar, colaborar y tomar decisiones rápidamente.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'18'],
            ['texto'=>'La agilidad es una característica central de nuestra organización, permitiéndonos adaptarnos rápidamente a los cambios y liderar en innovación y colaboración.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'18'],
            ['texto'=>'Aunque definimos algunos KPIs, su uso en la toma de decisiones es inconsistente y no se apoya en tableros de control efectivos.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'19'],
            ['texto'=>'Contamos con KPIs y los medimos con cierta regularidad, pero la integración de estos datos en la toma de decisiones aún puede mejorar.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'19'],
            ['texto'=>'Nuestros KPIs principales están claramente definidos y medidos a través de tableros de control, y juegan un papel crucial en nuestras decisiones estratégicas y tácticas.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'19'],
            ['texto'=>'Aún estamos en proceso de definir un modelo de datos que soporte efectivamente la toma de decisiones.','clasificacion'=>'Crawl','peso'=>'1','preguntaFk'=>'20'],
            ['texto'=>'Tenemos un modelo de datos básico y estamos trabajando en su mejor gestión para apoyar la toma de decisiones.','clasificacion'=>'Walk','peso'=>'2','preguntaFk'=>'20'],
            ['texto'=>'Nuestro modelo de datos está bien gestionado, permitiéndonos operar eficientemente y tomar decisiones basadas en información relevante y actualizada.','clasificacion'=>'Run','peso'=>'3','preguntaFk'=>'20'],


        ];

        foreach ($respuestasPreguntas as $respuestaPregunta) {
            \DB::table('respuestas_preguntas')->insert($respuestaPregunta);
        }
    }
}
