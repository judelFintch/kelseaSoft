<?php

namespace App\Livewire\Admin\Licence;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Licence;

class LicenceShow extends Component
{
    public Licence $license;

    public function mount($id)
    {
        $this->license = Licence::with(['supplier', 'company', 'customsOffice'])->findOrFail($id);
    }
    public function render()
    {
        return view('livewire.admin.licence.licence-show');
    }
}
