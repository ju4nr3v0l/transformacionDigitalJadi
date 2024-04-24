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

        foreach ($dimensiones as $dimension) {
            $respuestaFunc = $this->generarRecomendacionYpromt($user,$consolidado['data'][$dimension->nombre],$dimension->nombre);
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

        //marcamos las ya generadas
        foreach ($preguntasSinRecomendacionCopilot as $preguntas){

            $preguntas->recomendacion_copilot = 'generada';
            $preguntas->save();
        }

        //retornamos la finalizacion del proceso
        return response()->json(['message' => 'Recomendaciones generadas correctamente'], 200);

    }


    private function obtenerPreguntasSinRecomendacionCopilot($id_usuario)
    {
        $respuestasUsuariosSinRecomentacion = RespuestasUsuarios::Where('usuarioFk', $id_usuario)->whereNull('recomendacion_copilot')->get();


        return $respuestasUsuariosSinRecomentacion;
    }

    private function generarRecomendacionYpromt($user,$consolidado,$dimension){
        $respuesta = [];
        $openAi = new OpenAiService();
        $promt = "Teniendo el contexto de que el usuario " . $user->nombre_inmobiliaria . " y que sus objetivos frente a la transformacion digital son:". $user->objetivos_transformacion_digital .", Sus desafios y riesgos son:-" . $user->desafios_riesgos . " Y su experiencia en transformacion digital es: - ". $user->experiencia_transformacion_digital ." y se esta analizando la dimension a analizar es ". $dimension . "  ha respondido las preguntas:  ";

        foreach($consolidado as $capadidad){
            $promt .= "- ".$capadidad['pregunta'] . " con la respuesta: " . $capadidad['respuesta'] . "
            ";
        }
        $promt .= "Con base a esas respuestas, que le recomiendas para mejorar en la dimension ". $dimension . "? y cual es tu diagnóstico de la situación actual?";
        $respuesta['promt'] = $promt;
        $respuesta['recomendacion'] = $openAi->generateText($promt);
        return $respuesta;
    }

}
