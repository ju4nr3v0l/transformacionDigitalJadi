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
    public $respuestas1 = [1,2,3,4,5];
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
            $respuestas = RespuestasUsuarios::where('usuarioFk', $existe->id)->get();
            if($respuestas->count() == 0){
                $this->pregunta1 = preguntas::whereBetween('preguntaId',[1,5])->get();
//                dd($this->pregunta1);
                $this->currentStep = 1;
            } else {
                $step = ($respuestas->count())/4;
                $this->currentStep = $step;
                //toDo: implementar logica para traer grupo de preguntas correspondientes al step
            }
        }
    }

    public function unoStepSubmit()
    {
        dd($this);

//        foreach ($this->pregunta1 as $key => $value){
//            $respuesta = new RespuestasUsuarios();
//            $respuesta->respuestaFk = $value;
//            $respuesta->usuarioFk = $existe->id;
//            $respuesta->save();
//        }

        $this->currentStep = 2;

    }

    public function dosStepSubmit()
    {
        $this->currentStep = 3;
    }

    public function tresStepSubmit()
    {
        $this->currentStep = 4;
    }


    public function back($step)
    {
        $this->currentStep = $step;
    }
}
