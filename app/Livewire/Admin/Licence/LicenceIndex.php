<?php

namespace App\Livewire\Admin\Licence;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Licence;
class LicenceIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $licenses = Licence::query()
            ->with('company')
            ->where(function ($query) {
                $query->where('license_number', 'like', "%{$this->search}%")
                    ->orWhere('license_type', 'like', "%{$this->search}%")
                    ->orWhereHas('company', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%");
                    });
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.admin.licence.licence-index', compact('licenses'));
    }

    public function delete($id)
    {
        Licence::findOrFail($id)->delete();
        session()->flash('success', 'Licence supprimée avec succès.');
    }
}
