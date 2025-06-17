<?php

namespace App\Livewire\Admin\Licence;

use App\Models\Licence;
use App\Models\Company;
use App\Models\Bivac;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\LicenceFile;

class LicenceCreate extends Component
{
    use WithFileUploads;
    // Champs de formulaire
    public $license_number;
    public $license_type;
    public $license_category;
    public $currency = 'USD';

    public $max_folders = 1;
    public $initial_weight = 0;
    public $initial_fob_amount = 0;
    public $quantity_total = 0;

    public $freight_amount;
    public $insurance_amount;
    public $other_fees;
    public $cif_amount;

    public $payment_mode;

    // Fichier de la licence
    public $file;

    // BIVAC associé
    public $bivac_id;

    // Relation principale
    public $company_id;

    protected $rules = [
        'license_number' => 'required|unique:licences,license_number',
        'license_type' => 'required|string',
        'license_category' => 'nullable|string',
        'currency' => 'required|string',

        'max_folders' => 'required|integer|min:1',
        'initial_weight' => 'required|numeric|min:0',
        'initial_fob_amount' => 'required|numeric|min:0',
        'quantity_total' => 'required|numeric|min:0',

        'freight_amount' => 'nullable|numeric',
        'insurance_amount' => 'nullable|numeric',
        'other_fees' => 'nullable|numeric',
        'cif_amount' => 'nullable|numeric',

        'payment_mode' => 'nullable|string',
        'company_id' => 'required|exists:companies,id',
        'bivac_id' => 'nullable|exists:bivacs,id',
        'file' => 'nullable|file|max:10240',
    ];

    public function save()
    {
        $this->validate();

        $licence = Licence::create([
            'license_number' => $this->license_number,
            'license_type' => $this->license_type,
            'license_category' => $this->license_category,
            'currency' => $this->currency,

            'max_folders' => $this->max_folders,
            'remaining_folders' => $this->max_folders,
            'initial_weight' => $this->initial_weight,
            'remaining_weight' => $this->initial_weight,
            'initial_fob_amount' => $this->initial_fob_amount,
            'remaining_fob_amount' => $this->initial_fob_amount,
            'quantity_total' => $this->quantity_total,
            'remaining_quantity' => $this->quantity_total,

            'freight_amount' => $this->freight_amount,
            'insurance_amount' => $this->insurance_amount,
            'other_fees' => $this->other_fees,
            'cif_amount' => $this->cif_amount,

            'payment_mode' => $this->payment_mode,
            'company_id' => $this->company_id,
            'bivac_id' => $this->bivac_id,
        ]);

        if ($this->file) {
            $storedPath = $this->file->store('licence_files', 'public');
            $licence->files()->create([
                'name' => $this->file->getClientOriginalName(),
                'path' => $storedPath,
            ]);
        }

        session()->flash('success', 'Licence enregistrée avec succès.');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.licence.licence-create', [
            'companies' => Company::where('status', 'active')
                                  ->where('is_deleted', false)
                                  ->orderBy('name')
                                  ->get(),
            'bivacs' => Bivac::orderBy('label')->get(),
        ]);
    }
}
