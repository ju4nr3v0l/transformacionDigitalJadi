<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Capacidades;
use App\Models\preguntas;
use App\Models\RespuestasPreguntas;
use App\Models\RespuestasUsuarios;
use App\Models\Dimensiones;
use PDF;


use Illuminate\Http\Request;


class GenerarReporteController extends Controller
{
    public function generarReporte($idUsuario)
    {

        $respuestasUsuarios = $this->obtenerPreguntasConRecomendacion($idUsuario);
        foreach ($respuestasUsuarios as $respuestaUsuario) {
            $respuesta = RespuestasPreguntas::where('respuestaId', $respuestaUsuario->respuestaFk)->first();
            $pregunta = preguntas::where('preguntaId', $respuesta->preguntaFk)->first();
            $capacidad = Capacidades::where('capacidadId', $pregunta->capacidadFk)->first();
            $dimension = Dimensiones::where('dimensionId', $capacidad->dimensionFk)->first();
            $consolidado['data'][$dimension->nombre][$capacidad->nombre] = [
                'dimension' => $dimension->nombre,
                'capacidad' => $capacidad->nombre,
                'pregunta' => $pregunta->texto,
                'respuesta' => $respuesta->texto,
                'recomendacion' => $respuestaUsuario->recomendacion_copilot,
                'valor'=> $respuesta->peso,
                'clasificacion' => $respuesta->clasificacion,
            ];


        }

//        dd($consolidado);
        $pdf = PDF::loadView('myPDF', $consolidado);

        return $pdf->download('itsolutionstuff.pdf');


    }


    private function obtenerPreguntasConRecomendacion($id_usuario)
    {
        $respuestasUsuariosSinRecomentacion = RespuestasUsuarios::Where('usuarioFk', $id_usuario)->whereNotNull('recomendacion_copilot')->get();


        return $respuestasUsuariosSinRecomentacion;
    }
}
