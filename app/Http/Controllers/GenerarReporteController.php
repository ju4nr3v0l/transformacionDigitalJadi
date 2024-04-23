<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Capacidades;
use App\Models\preguntas;
use App\Models\RecomendacionPorDimensionModel;
use App\Models\RespuestasPreguntas;
use App\Models\RespuestasUsuarios;
use App\Models\Dimensiones;
use App\Models\UsuariosConsultoria;
use PDF;


use Illuminate\Http\Request;


class GenerarReporteController extends Controller
{
    public function generarReporte($idUsuario)
    {

        $respuestasUsuarios = $this->obtenerPreguntasConRecomendacion($idUsuario);
        $usuario = UsuariosConsultoria::where('usuarioConsultoriaId', $idUsuario)->first();
        foreach ($respuestasUsuarios as $respuestaUsuario) {
            $respuesta = RespuestasPreguntas::where('respuestaId', $respuestaUsuario->respuestaFk)->first();
            $pregunta = preguntas::where('preguntaId', $respuesta->preguntaFk)->first();
            $capacidad = Capacidades::where('capacidadId', $pregunta->capacidadFk)->first();
            $dimension = Dimensiones::where('dimensionId', $capacidad->dimensionFk)->first();
            $recomendacion = RecomendacionPorDimensionModel::where('usuarioFk', $idUsuario)->where('dimensionFk', $dimension->dimensionId)->first();
            $consolidado['data'][$dimension->nombre][$capacidad->nombre] = [
                'dimension' => $dimension->nombre,
                'capacidad' => $capacidad->nombre,
                'descripcion_capacidad' => $capacidad->descripcion,
                'pregunta' => $pregunta->texto,
                'respuesta' => $respuesta->texto,
                'recomendacion' => $respuestaUsuario->recomendacion_copilot,
                'valor'=> $respuesta->peso,
                'clasificacion' => $respuesta->clasificacion,

            ];
            $consolidado['data'][$dimension->nombre]['recomendacion'] =   preg_replace('/\*\*(.+)\*\*/sU', '', $recomendacion->recomendacion_copilot);;
            $consolidado['data'][$dimension->nombre]['promt'] = $recomendacion->promt;
            $consolidado['data'][$dimension->nombre]['nombre'] = $dimension->nombre;
            $consolidado['data'][$dimension->nombre]['promt'] = $recomendacion->promt;



        }


        $pdf = PDF::loadView('myPDF', $consolidado);

        return $pdf->download($usuario->nombre_inmobiliaria . '.pdf');


    }


    private function obtenerPreguntasConRecomendacion($id_usuario)
    {
        $respuestasUsuariosSinRecomentacion = RespuestasUsuarios::Where('usuarioFk', $id_usuario)->whereNotNull('recomendacion_copilot')->get();


        return $respuestasUsuariosSinRecomentacion;
    }
}
