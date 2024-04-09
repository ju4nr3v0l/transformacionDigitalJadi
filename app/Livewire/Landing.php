<?php

namespace App\Livewire;

use Livewire\Component;

class Landing extends Component
{
    public function render()
    {
        return view('livewire.landing');
    }

    public function inicio()
    {
        return view('inicioConsultoria');
    }
}
