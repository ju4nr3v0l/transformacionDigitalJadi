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
    public $nombreCompleto, $correo, $celular, $nit, $nombreInmobiliaria, $cargo, $preInicio1,$preInicio2, $preInicio3;
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
            'celular' => 'required|numeric|min:10',
            'nit' => 'required',
            'nombreInmobiliaria' => 'required',
            'cargo' => 'required',
            'preInicio1' => 'required',
            'preInicio2' => 'required',
            'preInicio3' => 'required',
        ], [
            'nombreCompleto.required' => 'El nombre completo es requerido',
            'correo.required' => 'El correo es requerido',
            'correo.email' => 'El correo no es válido',
            'celular.required' => 'El celular es requerido',
            'celular.numeric' => 'El celular debe ser numérico',
            'celular.min' => 'El celular debe tener al menos 10 digitos',
            'nit.required' => 'El nit es requerido',
            'nombreInmobiliaria.required' => 'El nombre de la inmobiliaria es requerido',
            'cargo.required' => 'El cargo es requerido',
            'preInicio1.required' => 'La respuesta frente a Objetivos de Transformación Digital es requerida',
            'preInicio2.required' => 'La respuesta frente a Desafíos y Riesgos es requerida',
            'preInicio3.required' => 'La respuesta frente a Experiencia en Transformación Digital es requerida',
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
            $usuarioConsultoria->objetivos_transformacion_digital = $this->preInicio1;
            $usuarioConsultoria->desafios_riesgos = $this->preInicio2;
            $usuarioConsultoria->experiencia_transformacion_digital = $this->preInicio3;
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

        ], [
            'respuesta1.required' => 'La respuesta 1 es requerida',
            'respuesta2.required' => 'La respuesta 2 es requerida',
            'respuesta3.required' => 'La respuesta 3 es requerida',
            'respuesta4.required' => 'La respuesta 4 es requerida',
            'respuesta5.required' => 'La respuesta 5 es requerida',
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

        ], [
            'respuesta6.required' => 'La respuesta 6 es requerida',
            'respuesta7.required' => 'La respuesta 7 es requerida',
            'respuesta8.required' => 'La respuesta 8 es requerida',
            'respuesta9.required' => 'La respuesta 9 es requerida',
            'respuesta10.required' => 'La respuesta 10 es requerida',
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

        ], [
            'respuesta11.required' => 'La respuesta 11 es requerida',
            'respuesta12.required' => 'La respuesta 12 es requerida',
            'respuesta13.required' => 'La respuesta 13 es requerida',
            'respuesta14.required' => 'La respuesta 14 es requerida',
            'respuesta15.required' => 'La respuesta 15 es requerida',
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

        ], [
            'respuesta16.required' => 'La respuesta 16 es requerida',
            'respuesta17.required' => 'La respuesta 17 es requerida',
            'respuesta18.required' => 'La respuesta 18 es requerida',
            'respuesta19.required' => 'La respuesta 19 es requerida',
            'respuesta20.required' => 'La respuesta 20 es requerida',
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
