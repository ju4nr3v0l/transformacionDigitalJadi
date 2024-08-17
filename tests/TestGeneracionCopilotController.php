<?php

namespace Tests;

use App\Http\Controllers\GeneracionCopilotController;
use App\Models\Dimensiones;
use App\Models\UsuariosConsultoria;
use App\Services\OpenAiService;
use TestGeneracionCopilotController;
use PHPUnit\Framework\TestCase;

class GeneracionCopilotControllerTest extends TestCase
{
    //Create unit test for function generarRecomendacionCopilot
    public function test_generarRecomendacionCopilot()
    {
        $generacionCopilotController = new GeneracionCopilotController();
        $id_usuario = 1;
        $result = $generacionCopilotController->generarRecomendacionCopilot($id_usuario);
        $this->assertEquals($result, 'recomendacion_copilot');
    }
    //Create unit test for function obtenerPreguntasSinRecomendacionCopilot
    public function test_obtenerPreguntasSinRecomendacionCopilot()
    {
        $generacionCopilotController = new GeneracionCopilotController();
        $id_usuario = 1;
        $result = $generacionCopilotController->obtenerPreguntasSinRecomendacionCopilot($id_usuario);
        $this->assertEquals($result, 'preguntasSinRecomendacionCopilot');
    }
    //Create unit test for function generarRecomendacionYpromt
    public function test_generarRecomendacionYpromt()
    {
        $openAi = new OpenAiService();
        $generacionCopilotController = new GeneracionCopilotController();
        $id_usuario = 1;
        $user = UsuariosConsultoria::find($id_usuario);
        $consolidado = [];
        $dimension = Dimensiones::all();
        $threadId = $openAi->createThread();
        $result = $generacionCopilotController->generarRecomendacionYpromt($user,$consolidado['data'][$dimension->nombre],$dimension->nombre,$threadId);
        $this->assertEquals($result, 'recomendacionYpromt');
    }

}
