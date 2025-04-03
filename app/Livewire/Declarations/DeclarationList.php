<?php

namespace App\Livewire\Declarations;

use Livewire\Component;
use App\Services\Declarations\DeclarationService;

class DeclarationList extends Component
{

    public $declarations = [];

    public function mount()
    {
        $this->declarations = DeclarationService::getDeclarations();
    }
    public function render()
    {
        return view(
            'livewire.declarations.declaration-list',
            ['declarations' => $this->declarations]
        );
    }
}
