<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 3600);
use App\Models\preguntas;
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

        $preguntasSinRecomendacionCopilot = $this->obtenerPreguntasSinRecomendacionCopilot($id_usuario);
        $user = UsuariosConsultoria::find($id_usuario);
        $openAi = new OpenAiService();
        foreach ($preguntasSinRecomendacionCopilot as $preguntas){


            $respuesta = RespuestasPreguntas::where('respuestaId', $preguntas->respuestaFk)->first();
            $pregunta = preguntas::where('preguntaId', $respuesta->preguntaFk)->first();
            $promt = "Teniendo el contexto de que el usuario " . $user->nombre_inmobiliaria . " y que sus objetivos frente a la transformacion digital son:". $user->objetivos_transformacion_digital .", Sus desafios y riesgos son:-" . $user->desafios_riesgos . " Y su experiencia en transformacion digital es: - ". $user->experiencia_transformacion_digital ." ha respondido la pregunta " . $pregunta->texto . " con la respuesta " . $respuesta->texto ." ¿Cuál sería tu recomendación para el usuario?";
            $respuesta_copilot = $openAi->generateText($promt);

            $preguntas->recomendacion_copilot = $respuesta_copilot;
            $preguntas->save();


        }

        return response()->json(['message' => 'Recomendaciones generadas correctamente'], 200);

    }


    private function obtenerPreguntasSinRecomendacionCopilot($id_usuario)
    {
        $respuestasUsuariosSinRecomentacion = RespuestasUsuarios::Where('usuarioFk', $id_usuario)->whereNull('recomendacion_copilot')->get();


        return $respuestasUsuariosSinRecomentacion;
    }

}
