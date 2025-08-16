<?php

namespace App\Livewire\Admin\Billing;

use Livewire\Component;
use App\Models\Folder;

class BillingCreate extends Component
{
    public $folder;
    public $liquidationItems = [];
    public $feeItems = [];
    public $totalLiquidation = 0;
    public $totalFees = 0;
    public $totalAmount = 0;

    public function mount(Folder $folder)
    {
        $this->folder = $folder;
        $this->liquidationItems = [
            ['designation' => 'ANA ANAPI 96% de 5% TPI', 'amount' => 17810],
            ['designation' => 'AT1 DGRAD Fonds Propres 17.5%', 'amount' => 300585],
            ['designation' => 'AT2 DGDA Fonds Propres 7.5%', 'amount' => 128822],
            ['designation' => 'AT3 DGDA Receveur Fonds Propr 5%', 'amount' => 85881],
            ['designation' => 'AT4 Commerce Extérieur 10%', 'amount' => 171763],
            ['designation' => 'AT5 DGRAD Investissement 10%', 'amount' => 171763],
            ['designation' => 'PLT DGRAD Trésor 50%', 'amount' => 858815],
            ['designation' => 'CTL Frais de contrôle OCC', 'amount' => 561150],
            ['designation' => 'PNO Frais pénalités OCC', 'amount' => 561150],
            ['designation' => 'ROC Retenue 0.3% frais OCC', 'amount' => 5212],
            ['designation' => 'TVO TVA OCC', 'amount' => 277982],
            ['designation' => 'LAB Frais Labo OCC', 'amount' => 589038],
            ['designation' => 'RET Retribution DGDA', 'amount' => 31980],
            ['designation' => 'RAN Retenue ANAPI 4%', 'amount' => 742],
            ['designation' => 'DDI Droit de Douanes à l\'Import', 'amount' => 1377586],
            ['designation' => 'TVA Valeur Ajoutée', 'amount' => 1603802],
            ['designation' => 'RLS Logistique SNCC', 'amount' => 242120],
            ['designation' => 'TPI Promotion Industrie', 'amount' => 341391],
            ['designation' => 'COG Commission OGEFREM', 'amount' => 78495],
            ['designation' => 'RCO Rétribution Ogefrem', 'amount' => 4292],
            ['designation' => 'CSO Comité de Suivi OGEFREM', 'amount' => 3090],
            ['designation' => 'TVF TVA Ogefrem', 'amount' => 13740],
            ['designation' => 'RII Informatique à l\'Import', 'amount' => 386465],
            ['designation' => 'RCC Suivi de Change', 'amount' => 32807],
            ['designation' => 'RRC Retenue 4.5% RCC', 'amount' => 1545]
        ];

        $this->addFeeItem();
        $this->recalculateTotals();
    }

    public function addLiquidationItem()
    {
        $this->liquidationItems[] = ['designation' => '', 'amount' => 0];
        $this->recalculateTotals();
    }

    public function removeLiquidationItem($index)
    {
        unset($this->liquidationItems[$index]);
        $this->liquidationItems = array_values($this->liquidationItems);
        $this->recalculateTotals();
    }

    public function addFeeItem()
    {
        $this->feeItems[] = ['designation' => '', 'amount' => 0];
        $this->recalculateTotals();
    }

    public function removeFeeItem($index)
    {
        unset($this->feeItems[$index]);
        $this->feeItems = array_values($this->feeItems);
        $this->recalculateTotals();
    }

    public function recalculateTotals()
    {
        $this->totalLiquidation = collect($this->liquidationItems)->sum('amount');
        $this->totalFees = collect($this->feeItems)->sum('amount');
        $this->totalAmount = $this->totalLiquidation + $this->totalFees;
    }

    public function saveInvoice()
    {
        // Implémentation future
    }

    public function printInvoice()
    {
        // Implémentation future
    }

    public function render()
    {
        return view('livewire.admin.billing.billing-create');
    }
}
