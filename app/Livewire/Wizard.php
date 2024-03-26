<?php

namespace App\Livewire;

use App\Models\UsuariosConsultoria;
use Livewire\Component;

class Wizard extends Component
{

    public $currentStep = 0;
    public $nombreCompleto, $correo, $celular, $nit, $nombreInmobiliaria, $cargo;
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

        $this->currentStep = 1;

    }

    public function unoStepSubmit()
    {
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
