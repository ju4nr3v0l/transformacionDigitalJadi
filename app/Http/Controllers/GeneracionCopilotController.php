<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 3600);

use App\Models\Capacidades;
use App\Models\Dimensiones;
use App\Models\preguntas;
use App\Models\RecomendacionPorDimensionModel;
use App\Models\RespuestasPreguntas;
use App\Models\RespuestasUsuarios;
use App\Models\UsuariosConsultoria;
use App\Services\OpenAiService;
use App\Services\OpenAiServiceResumenEjecutivo;
use Illuminate\Http\Request;

class GeneracionCopilotController extends Controller
{
    //Obtener preguntas sin el campo recomendacion_copilot agrupados por usuario

    Public function generarRecomendacionCopilot($id_usuario)
    {
        //consultamos los faltantes por generar
        $preguntasSinRecomendacionCopilot = $this->obtenerPreguntasSinRecomendacionCopilot($id_usuario);
        $user = UsuariosConsultoria::find($id_usuario);
        $consolidado = [];
        foreach ($preguntasSinRecomendacionCopilot as $preguntas){
            $respuesta = RespuestasPreguntas::where('respuestaId', $preguntas->respuestaFk)->first();
            $pregunta = preguntas::where('preguntaId', $respuesta->preguntaFk)->first();
            $capacidad = Capacidades::where('capacidadId', $pregunta->capacidadFk)->first();
            $dimension = Dimensiones::where('dimensionId', $capacidad->dimensionFk)->first();
            $consolidado['data'][$dimension->nombre][$capacidad->nombre] = [
                'dimension' => $dimension->nombre,
                'capacidad' => $capacidad->nombre,
                'pregunta' => $pregunta->texto,
                'respuesta' => $respuesta->texto,
                'valor'=> $respuesta->peso,
                'clasificacion' => $respuesta->clasificacion,
            ];
        }

        //generamos las remomendaciones por dimension y guardamos

        $dimensiones = Dimensiones::all();
        $openAi = new OpenAiService();
        $threadId = $openAi->createThread();
        foreach ($dimensiones as $dimension) {
            $respuestaFunc = $this->generarRecomendacionYpromt($user,$consolidado['data'][$dimension->nombre],$dimension->nombre,$threadId);
            $consolidado['data'][$dimension->nombre]['recomendacion_copilot'] = $respuestaFunc['recomendacion'];
            $consolidado['data'][$dimension->nombre]['promt'] = $respuestaFunc['promt'];
            $recomendacion = new RecomendacionPorDimensionModel();
            $recomendacion->usuarioFk = $id_usuario;
            $recomendacion->dimensionFk = $dimension->dimensionId;
            $recomendacion->fecha = date('Y-m-d H:i:s');
            $recomendacion->recomendacion_copilot = $respuestaFunc['recomendacion'];
            $recomendacion->promt = $respuestaFunc['promt'];
            $recomendacion->save();

        }

        // Generamos el resumen ejecutivo

        $resumenEjecutivo = $openAi->generateText($threadId,"entregame un parrafo de resumen ejecutivo de las dimensiones, prioriza las más relevantes por su fortaleza o debilidad en la organización de maximo 500 palabras");
        $user->resumen_ejecutivo = $resumenEjecutivo;
        $user->save();

        //marcamos las ya generadas
        foreach ($preguntasSinRecomendacionCopilot as $preguntas){

            $preguntas->recomendacion_copilot = 'generada';
            $preguntas->save();
        }

        $prioridades = $this->generarPrioridades($threadId);
        $user->prioridades = $prioridades;
        $user->save();

        $formacion = $this->generarFormacion($threadId);
        $user->formacion = $formacion;
        $user->save();

        //retornamos la finalizacion del proceso
        return response()->json(['message' => 'Recomendaciones generadas correctamente'], 200);

    }


    public function obtenerPreguntasSinRecomendacionCopilot($id_usuario)
    {
        $respuestasUsuariosSinRecomentacion = RespuestasUsuarios::Where('usuarioFk', $id_usuario)->whereNull('recomendacion_copilot')->get();


        return $respuestasUsuariosSinRecomentacion;
    }

    public function generarRecomendacionYpromt($user, $consolidado, $dimension, $trheadId){

        $respuesta = [];
        $openAi = new OpenAiService();

        $promt = "Teniendo el contexto de que el usuario " . $user->nombre_inmobiliaria . " y que sus objetivos frente a la transformacion digital son:". $user->objetivos_transformacion_digital .", Sus desafios y riesgos son:-" . $user->desafios_riesgos . " Y su experiencia en transformacion digital es: - ". $user->experiencia_transformacion_digital ." y se esta analizando la dimension a analizar es ". $dimension . "  ha respondido las preguntas:  ";

        foreach($consolidado as $capadidad){
           $promt .= "- ".$capadidad['pregunta'] . " con la respuesta: " . $capadidad['respuesta'] . "
            ";
        }
//        $promt .= "Con base a esas respuestas, que le recomiendas para mejorar en la dimension ". $dimension . "? y cual es tu diagnóstico de la situación actual?";
        $respuesta['promt'] = $promt;

        $respuesta['recomendacion'] = $openAi->generateText($trheadId,$promt);
        return $respuesta;
    }

    public function generarPrioridades($trheadId){
        $openAi = new OpenAiService();
        $promt = "De acuerdo a las recomendaciones generadas dame un plan con la siguiente estructura:
        Horizonte a 3 meses, el top 3 de cosas más urgentes por atender de acuerdo a las principales expectativas y necesidades de la empresa.

        Horizonte 1 año:
El top 3 de cosas más importantes por atender de acuerdo a las principales expectativas y necesidades de la empresa, que no se hayan incluido en el horizonte 1.

Horizonte 2 años:
El top 5 de cosas más importantes por atender de acuerdo a las principales expectativas y necesidades de la empresa, que puedan dar una espera o requieran la estructuración de bases previas con los horizontes anteriores.
en este plan, incluye iniciativas que garanticen la generación de valor desde el primer trimestre con recomendaciones que tengan un impacto fuerte para la organización. Prioriza primero lo que genera más impacto. Debes hacer esto en maximo 500 palabras";

        $respuesta = $openAi->generateText($trheadId,$promt);
        return $respuesta;
    }

    public function generarFormacion($trheadId){
        $openAi = new OpenAiService();
        $promt = "De acuerdo a las recomendaciones generadas dame un plan de formación con los principales temas en los que el gerente se debe enfocar en su formación para promover el cambio y la transformación digital según su realidad. los temas son:

Módulo 1: Introducción a la Transformación Digital
Objetivo: Proporcionar una visión integral de la transformación digital y su impacto en las organizaciones y la sociedad.
Contenido:
Conceptos fundamentales de la transformación digital.
Tecnologías emergentes y su aplicación.
Estrategias de transformación digital.
Casos de estudio y análisis de empresas que han implementado la transformación digital.
Desafíos y oportunidades.

Módulo 2: Experiencia de Cliente
Objetivo: Entender la importancia de la experiencia del cliente en el contexto digital y mejorar la interacción con los clientes.
Contenido:
Principios de UX (User Experience).
Customer Journey Mapping.
Personalización a través de datos, uso de CRM avanzados.
Análisis de feedback en tiempo real.

Módulo 3: Cultura Cambio y Agilidad Organizacional
Objetivo: Reconocer la influencia de la cultura organizacional en la transformación digital.
Contenido:
Gestión del cambio en ambientes digitales.
Desarrollo de equipos ágiles.
Introducción a las metodologías ágiles (SCRUM y KANBAN).
Herramientas para gestión de agilismo (Jira, Azure DevOps).
Liderazgo digital.

Módulo 4: Tecnologías Disruptivas y Arquitectura
Objetivo: Reconocer la importancia de los datos en la toma de decisiones estratégicas y comprender cómo las decisiones arquitectónicas afectan la estrategia y operaciones.
Contenido:
Internet de las Cosas (IoT).
Big Data y Analítica de Datos.
Inteligencia Artificial y su aplicación en el sector inmobiliario.
Blockchain, Realidad Aumentada y Realidad Virtual.
Principios de arquitectura de TI.

Módulo 5: Innovación e Implementación de la Transformación Digital
Objetivo: Entender el rol de la innovación en la diferenciación y el crecimiento del negocio.
Contenido:
Innovación abierta y colaboración con startups.
Prototipado rápido.
Design Thinking.
Casos de éxito y experiencias reales.

Módulo 6: Evaluación y Medición del Impacto
Objetivo: Evaluar y medir el impacto de la transformación digital en la organización.
Contenido:
KPIs y métricas para la evaluación.
Herramientas de monitoreo y análisis.
OKR y ajuste continuo de estrategias.

Debes hacer esto en maximo 500 palabras.";
        $respuesta = $openAi->generateText($trheadId,$promt);
        return $respuesta;
    }

//    private function generarResumenEjecutivo($idUsuario)
//    {
//
//        $promt = "Teniendo en cuenta las siguientes recomendaciones generadas por CoPilot: ";
//        $user = UsuariosConsultoria::find($idUsuario);
//
//        $recomendaciones = RecomendacionPorDimensionModel::where('usuarioFk', $idUsuario)->get();
//        foreach ($recomendaciones as $recomendacion) {
//            $promt .= "- " . $recomendacion->recomendacion_copilot . "
//            ";
//        }
//        $promt .= " Dame un resumen ejecutivo para la empresa {$user->nombre_inmobiliaria}";
//
//        $openAiResumen = new OpenAiServiceResumenEjecutivo();
//        $resumenEjecutivo = $openAiResumen->generateText($promt);
//        return $resumenEjecutivo;
//
//    }

}
