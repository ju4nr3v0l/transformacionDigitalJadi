<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Capacidades;
use App\Models\Dimensiones;
use App\Models\preguntas;
use App\Models\RecomendacionPorDimensionModel;
use App\Models\RespuestasPreguntas;
use App\Models\RespuestasUsuarios;
use App\Models\UsuariosConsultoria;
use App\Services\OpenAiServiceResumenEjecutivo;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function test()
    {
        $respuestas = RespuestasUsuarios::where('usuarioFk', 49)
            ->join('respuestas_preguntas', 'respuestas_preguntas.respuestaId', '=', 'respuestas_usuarios.respuestaFk')
            ->join('preguntas', 'preguntas.preguntaId', '=', 'respuestas_preguntas.preguntaFk')
            ->join('capacidades', 'capacidades.capacidadId', '=', 'preguntas.capacidadFk')
            ->join('dimensiones', 'dimensiones.dimensionId', '=', 'capacidades.dimensionFk')
            ->select('dimensiones.nombre as dimension', 'capacidades.nombre as capacidad','respuestas_usuarios.respuestaFk', 'preguntas.texto as pregunta')
            ->get();

        $result = [];

        foreach ($respuestas as $respuesta) {
            $dimension = $respuesta->dimension;
            $capacidad = $respuesta->capacidad;

            if (!isset($result[$dimension])) {
                $result[$dimension] = [];
            }

            if (!isset($result[$dimension][$capacidad])) {
                $result[$dimension][$capacidad] = [];
            }

            $result[$dimension][$capacidad][] = [
                'pregunta' => $respuesta->pregunta,
                'valor' => $respuesta->valor
            ];
        }

        dd($result);

        return $result;

    }


}
