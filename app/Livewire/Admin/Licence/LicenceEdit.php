<?php

namespace App\Livewire\Admin\Licence;

use Livewire\Component;
use App\Models\Licence;
use App\Models\Company;
use App\Models\Bivac;
use App\Services\Licence\LicenceService;

class LicenceEdit extends Component
{
    public Licence $license;

    // Form fields
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

    // Relations
    public $company_id;
    public $bivac_id;

    public function mount($id)
    {
        $this->license = Licence::findOrFail($id);

        $this->license_number = $this->license->license_number;
        $this->license_type = $this->license->license_type;
        $this->license_category = $this->license->license_category;
        $this->currency = $this->license->currency;

        $this->max_folders = $this->license->max_folders;
        $this->initial_weight = $this->license->initial_weight;
        $this->initial_fob_amount = $this->license->initial_fob_amount;
        $this->quantity_total = $this->license->quantity_total;

        $this->freight_amount = $this->license->freight_amount;
        $this->insurance_amount = $this->license->insurance_amount;
        $this->other_fees = $this->license->other_fees;
        $this->cif_amount = $this->license->cif_amount;

        $this->payment_mode = $this->license->payment_mode;

        $this->company_id = $this->license->company_id;
        $this->bivac_id = $this->license->bivac_id;
    }

    protected function rules()
    {
        return [
            'license_number' => 'required|unique:licences,license_number,' . $this->license->id,
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
        ];
    }

    public function updateLicense()
    {
        $validated = $this->validate();

        app(LicenceService::class)->updateLicense($this->license, $validated);

        session()->flash('success', 'Licence mise à jour avec succès.');

        return redirect()->route('licence.show', $this->license->id);
    }

    public function render()
    {
        return view('livewire.admin.licence.licence-edit', [
            'companies' => Company::where('status', 'active')
                                  ->where('is_deleted', false)
                                  ->orderBy('name')
                                  ->get(),
            'bivacs' => Bivac::orderBy('label')->get(),
        ]);
    }
}
