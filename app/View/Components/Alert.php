<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;

    // Le constructeur pour accepter des données
    public function __construct($type)
    {
        $this->type = $type;
    }

    public function render()
    {
        return view('components.alert'); // La vue associée au composant
    }
}
