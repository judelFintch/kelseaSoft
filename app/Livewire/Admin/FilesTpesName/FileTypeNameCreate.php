<?php

namespace App\Livewire\Admin\FilesTpesName;

use Livewire\Component;
use App\Models\DocumentType;
use Livewire\WithPagination;

class FileTypeNameCreate extends Component
{


    use WithPagination;

    public $name;
    public $editingId = null;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|min:2|max:255',
    ];


   
    public function save()
    {
        $this->validate();

        DocumentType::updateOrCreate(
            ['id' => $this->editingId],
            ['name' => $this->name]
        );

        session()->flash('success', 'Type de document ' . ($this->editingId ? 'modifié' : 'ajouté') . ' avec succès.');

        $this->reset(['name', 'editingId']);
    }

    public function edit($id)
    {
        $type = DocumentType::findOrFail($id);
        $this->name = $type->name;
        $this->editingId = $type->id;
    }

    public function delete($id)
    {
        DocumentType::findOrFail($id)->delete();
        session()->flash('success', 'Type supprimé avec succès.');
    }
    public function render()
    {

        $types = DocumentType::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);
        return view(
            'livewire.admin.files-tpes-name.file-type-name-create',
            [
                'types' => $types,
            ]
        );
    }
}
