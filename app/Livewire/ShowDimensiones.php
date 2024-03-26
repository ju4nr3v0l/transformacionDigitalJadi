<?php

namespace App\Livewire;


use App\Models\Dimensiones;
use Livewire\Component;

class ShowDimensiones extends Component
{
    public $dimensiones;


    public function boot()
    {
    $this->dimensiones = Dimensiones::all()->load('capacidades');
        dump($this->dimensiones[0]->capacidades);
    }

    public function render()
    {
        return view('livewire.show-dimensiones');
    }
}
