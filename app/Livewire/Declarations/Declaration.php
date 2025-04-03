<?php

namespace App\Livewire\Declarations;

use Livewire\Component;
use App\Services\Declarations\DeclarationService;

class Declaration extends Component
{

    public $total = 10;
    public $enCours = 0;
    public $validees = 0;
    public $liquidees = 0;
    public $declarations = 0;


    public function mount(){
        $this->declarations = DeclarationService::getDeclarations();
    }


    public function render()
    {
        return view('livewire.declarations.declaration'
    ,['declarations' =>$this->declarations]);
    }
}
