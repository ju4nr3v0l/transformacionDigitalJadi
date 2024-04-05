<?php

namespace App\Livewire;

use App\Models\preguntas;
use App\Models\RespuestasUsuarios;
use App\Models\UsuariosConsultoria;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Wizard extends Component
{

    public $currentStep = 0;
    public $nombreCompleto, $correo, $celular, $nit, $nombreInmobiliaria, $cargo;
    public $pregunta1 = [];
    public $pregunta2 = [];
    public $pregunta3 = [];
    public $pregunta4 = [];
    public $pregunta5 = [];
    public $respuesta1;
    public $respuesta2;
    public $respuesta3;
    public $respuesta4;
    public $respuesta5;
    public $respuesta6;
    public $respuesta7;
    public $respuesta8;
    public $respuesta9;
    public $respuesta10;
    public $respuesta11;
    public $respuesta12;
    public $respuesta13;
    public $respuesta14;
    public $respuesta15;
    public $respuesta16;
    public $respuesta17;
    public $respuesta18;
    public $respuesta19;
    public $respuesta20;
    public $successMessage = '';

    public function render()
    {
        return view('livewire.wizard');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function ceroStepSubmit()
    {
        $validatedData = $this->validate([
            'nombreCompleto' => 'required',
            'correo' => 'required|email',
            'celular' => 'required|numeric',
            'nit' => 'required',
            'nombreInmobiliaria' => 'required',
            'cargo' => 'required',
        ]);

        $existe = UsuariosConsultoria::where('correo', $this->correo)->first();
        if(!$existe){
            $usuarioConsultoria = new UsuariosConsultoria();
            $usuarioConsultoria->nombre_completo = $this->nombreCompleto;
            $usuarioConsultoria->correo = $this->correo;
            $usuarioConsultoria->celular = $this->celular;
            $usuarioConsultoria->nit = $this->nit;
            $usuarioConsultoria->nombre_inmobiliaria = $this->nombreInmobiliaria;
            $usuarioConsultoria->cargo = $this->cargo;
            $usuarioConsultoria->step = 1;
            $usuarioConsultoria->save();
            $this->pregunta1 = preguntas::whereBetween('preguntaId',[1,5])->get();
            $this->currentStep = 1;
        } else {
            $respuestas = RespuestasUsuarios::where('usuarioFk', $existe->usuarioConsultoriaId)->get();
            if($respuestas->count() == 0){
                $this->pregunta1 = preguntas::whereBetween('preguntaId',[1,5])->get();
                $this->currentStep = 1;
            } else {
                $step = ($respuestas->count()/5)+1;
                if($step == 2){
                    $this->pregunta2 = preguntas::whereBetween('preguntaId',[6,10])->get();
                }elseif($step == 3){
                    $this->pregunta3 = preguntas::whereBetween('preguntaId',[11,15])->get();
                }elseif($step == 4){
                    $this->pregunta4 = preguntas::whereBetween('preguntaId',[16,20])->get();
                } else{
                    $step = 5;
                }
                $this->currentStep = $step;

            }
        }
    }

    public function unoStepSubmit()
    {

        $validatedData = $this->validate([
            'respuesta1' => 'required',
            'respuesta2' => 'required',
            'respuesta3' => 'required',
            'respuesta4' => 'required',
            'respuesta5' => 'required',

        ]);
        $usuario = UsuariosConsultoria::where('correo', $this->correo)->first();
        $this->saveRespuestaUsuarios($this->respuesta1, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta2, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta3, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta4, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta5, $usuario->usuarioConsultoriaId);

        $this->pregunta2 = preguntas::whereBetween('preguntaId',[6,10])->get();


        $this->currentStep = 2;

    }

    public function dosStepSubmit()
    {
        $validatedData = $this->validate([
            'respuesta6' => 'required',
            'respuesta7' => 'required',
            'respuesta8' => 'required',
            'respuesta9' => 'required',
            'respuesta10' => 'required',

        ]);
        $usuario = UsuariosConsultoria::where('correo', $this->correo)->first();
        $this->saveRespuestaUsuarios($this->respuesta6, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta7, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta8, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta9, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta10, $usuario->usuarioConsultoriaId);
        $this->pregunta3 = preguntas::whereBetween('preguntaId',[11,15])->get();



        $this->currentStep = 3;
    }

    public function tresStepSubmit()
    {
        $validatedData = $this->validate([
            'respuesta11' => 'required',
            'respuesta12' => 'required',
            'respuesta13' => 'required',
            'respuesta14' => 'required',
            'respuesta15' => 'required',

        ]);
        $usuario = UsuariosConsultoria::where('correo', $this->correo)->first();
        $this->saveRespuestaUsuarios($this->respuesta11, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta12, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta13, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta14, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta15, $usuario->usuarioConsultoriaId);
        $this->pregunta4 = preguntas::whereBetween('preguntaId',[16,20])->get();


        $this->currentStep = 4;
    }
    public function cuatroStepSubmit()
    {
        $validatedData = $this->validate([
            'respuesta16' => 'required',
            'respuesta17' => 'required',
            'respuesta18' => 'required',
            'respuesta19' => 'required',
            'respuesta20' => 'required',

        ]);
        $usuario = UsuariosConsultoria::where('correo', $this->correo)->first();
        $this->saveRespuestaUsuarios($this->respuesta16, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta17, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta18, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta19, $usuario->usuarioConsultoriaId);
        $this->saveRespuestaUsuarios($this->respuesta20, $usuario->usuarioConsultoriaId);



        $this->currentStep = 5;
    }


    public function back($step)
    {
        $this->currentStep = $step;
    }

    private function saveRespuestaUsuarios($idRespuesta, $idUsuario)
    {
        $respuesta = new RespuestasUsuarios();
        $respuesta->respuestaFk = $idRespuesta;
        $respuesta->usuarioFk = $idUsuario;
        $respuesta->fecha = now();
        $respuesta->save();
    }
}
