<?php

namespace App\Http\Controllers;

use App\Models\RespuestasUsuarios;
use Illuminate\Http\Request;

class GeneracionCopilotController extends Controller
{
    //Obtener preguntas sin el campo recomendacion_copilot agrupados por usuario

    Public function generarRecomendacionCopilot($id_usuario)
    {
        $preguntasSinRecomendacionCopilot = $this->obtenerPreguntasSinRecomendacionCopilot($id_usuario);
    }


    private function obtenerPreguntasSinRecomendacionCopilot($id_usuario)
    {
        $respuestasUsuariosSinRecomentacion = RespuestasUsuarios::class
            ->select('id_pregunta')
            ->where('id_usuario', $id_usuario)
            ->whereNull('recomendacion_copilot')
            ->groupBy('id_pregunta')
            ->get();
    }

}
