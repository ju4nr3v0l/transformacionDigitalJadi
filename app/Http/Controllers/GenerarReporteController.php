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

            $consolidado['data'][$dimension->nombre]['recomendacion'] =   str_replace( '*','',$recomendacion->recomendacion_copilot,);
            $consolidado['data'][$dimension->nombre]['promt'] = $recomendacion->promt;
            $consolidado['data'][$dimension->nombre]['nombre'] = $dimension->nombre;
            $consolidado['data'][$dimension->nombre]['promt'] = $recomendacion->promt;



        }

        foreach ($consolidado['data'] as $key => $dimension) {
            $acum = 0;
            $contador = 0;
            foreach ($dimension as $key2 => $capacidad) {
                    if($key2 == 'recomendacion' || $key2 == 'promt' || $key2 == 'nombre') {
                        continue;
                    } else {
                        $acum += $capacidad['valor'];
                        $contador++;
                    }
                 }
            $consolidado['data'][$key]['promedio'] = $acum / $contador;
            $consolidado['data'][$key]['Clasificacion'] = $this->obtenerClasificacion($consolidado['data'][$key]['promedio']);
        }

        $consolidado['data']['graficos']['dimensiones'] = '';
        $consolidado['data']['graficos']['valores'] = '';
        foreach ($consolidado['data'] as $key => $dimension){
            if($key == 'graficos') {
                continue;
            } else{
                $consolidado['data']['graficos']['dimensiones'] .="'". $key ."',";
                $consolidado['data']['graficos']['valores'] .= $dimension['promedio']. ",";
            }
        }

        $consolidado['data']['graficos']['dimensiones'] = substr($consolidado['data']['graficos']['dimensiones'], 0, -1);
        $consolidado['data']['graficos']['valores'] = substr($consolidado['data']['graficos']['valores'], 0, -1);
        $pdf = PDF::loadView('myPDF', $consolidado);

        return $pdf->download($usuario->nombre_inmobiliaria . '.pdf');


    }


    private function obtenerPreguntasConRecomendacion($id_usuario)
    {
        $respuestasUsuariosSinRecomentacion = RespuestasUsuarios::Where('usuarioFk', $id_usuario)->whereNotNull('recomendacion_copilot')->get();


        return $respuestasUsuariosSinRecomentacion;
    }

    private function obtenerClasificacion($valor)
    {
        if($valor >= 1 && $valor <= 1.9) {
            return 'Crawl';
        } else if($valor >=2 && $valor <= 2.9) {
            return 'Walk';
        } else {
            return 'Run';
        }
    }
}
