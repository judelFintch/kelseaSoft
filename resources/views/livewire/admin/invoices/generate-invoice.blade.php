<div class="w-full max-w-5xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">
    
    <h2 class="text-2xl font-bold">🧾 Nouvelle Facture</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded">{{ session('success') }}</div>
    @endif

    {{-- Barre de progression --}}
    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-6">
        <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-300"
            style="width: {{ (100 / (count($categorySteps) + 1)) * $step }}%">
        </div>
    </div>

    {{-- Étape 1 – Informations générales --}}
    @if ($step === 1)
        <div class="space-y-6">

            {{-- Section de Recherche/Sélection de Dossier --}}
            <div class="p-4 border rounded-md bg-slate-50">
                <label for="searchTermFolder" class="block text-sm font-medium text-gray-700 mb-1">Lier à un Dossier (Optionnel)</label>
                <input type="text" id="searchTermFolder"
                       wire:model.live.debounce.300ms="searchTermFolder"
                       placeholder="Rechercher par N° de dossier..."
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                <div wire:loading wire:target="searchTermFolder" class="text-sm text-gray-500 mt-1">Recherche en cours...</div>

                @if(!empty($searchableFolders))
                    <ul class="mt-2 border border-gray-300 rounded-md bg-white max-h-60 overflow-y-auto shadow">
                        @foreach($searchableFolders as $sFolder)
                            {{-- Livewire attend un tableau simple pour $sFolder si get()->toArray() est utilisé --}}
                            {{-- Si get() est utilisé, $sFolder est un objet Folder --}}
                            <li class="p-3 hover:bg-indigo-50 cursor-pointer border-b border-gray-200 last:border-b-0"
                                wire:click="selectFolder({{ $sFolder['id'] ?? $sFolder->id }})">
                                {{ $sFolder['folder_number'] ?? $sFolder->folder_number }}
                                @php
                                    // Essayer de trouver le nom de la compagnie si c'est un tableau
                                    // Ceci est une supposition, la structure exacte de $sFolder (array) dépend de ce qui est passé
                                    $companyName = '';
                                    if (is_array($sFolder) && isset($sFolder['company']) && is_array($sFolder['company'])) {
                                        $companyName = $sFolder['company']['name'] ?? '';
                                    } elseif (is_object($sFolder) && isset($sFolder->company)) {
                                        $companyName = $sFolder->company->name ?? '';
                                    } elseif(is_array($sFolder) && isset($sFolder['client'])) { // Au cas où la clé serait 'client'
                                        $companyName = $sFolder['client'];
                                    }
                                @endphp
                                @if($companyName)
                                    - {{ $companyName }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @elseif(!empty($searchTermFolder) && empty($searchableFolders) && !$selectedFolder)
                    <div class="mt-2 text-sm text-gray-500 p-3 bg-white border border-gray-300 rounded-md">Aucun dossier trouvé ou tous les dossiers correspondants sont déjà liés.</div>
                @endif

                @if($selectedFolder)
                    <div class="mt-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded-md shadow-sm">
                        <p class="font-semibold">Dossier lié : {{ $selectedFolder->folder_number }}</p>
                        <p class="text-sm">Client du dossier : {{ $selectedFolder->company?->name ?? ($selectedFolder->client ?? 'N/A') }}</p>
                        <button type="button" wire:click="clearSelectedFolder"
                                class="mt-2 text-sm text-red-600 hover:text-red-800 font-medium underline">
                            Désélectionner le dossier
                        </button>
                    </div>
                @endif
            </div>
            {{-- Fin Section de Recherche/Sélection de Dossier --}}


            <div class="grid grid-cols-2 gap-4">
                {{-- Le company_id sera pré-rempli si un dossier est sélectionné --}}
                <x-forms.select label="Société (Client)" model="company_id" :options="$companies" optionLabel="name"
                    optionValue="id" />
                <x-forms.input label="Date de Facture" model="invoice_date" type="date" />
            </div>

            <div class="grid grid-cols-3 gap-4">
                <x-forms.input label="Produit" model="product" />
                <x-forms.input label="Poids (kg)" model="weight" type="number" step="0.01" />
                <x-forms.input label="Code Opération" model="operation_code" />
            </div>

            <div class="grid grid-cols-4 gap-4">
                <x-forms.input label="FOB ($)" model="fob_amount" type="number" step="0.01" />
                <x-forms.input label="Assurance ($)" model="insurance_amount" type="number" step="0.01" />
                <x-forms.input label="Fret ($)" model="freight_amount" type="number" step="0.01" />
                <x-forms.input label="CIF ($)" model="cif_amount" type="number" step="0.01" />
            </div>

            <div class="grid grid-cols-3 gap-4">
                <x-forms.select label="Devise principale" model="currency_id" :options="$currencies" optionLabel="code"
                    optionValue="id" />
                <x-forms.input label="Taux de change vers CDF" model="exchange_rate" type="number" step="0.000001" />
                <x-forms.select label="Mode de paiement" model="payment_mode" :options="[['id' => 'provision', 'name' => 'Provision'], ['id' => 'comptant', 'name' => 'Comptant']]" optionLabel="name"
                    optionValue="id" />
            </div>

            <div class="pt-4 flex justify-end">
                <button wire:click="nextStep" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Étape suivante →
                </button>
            </div>
        </div>
    @endif

    {{-- Étapes dynamiques par catégorie --}}
    @foreach ($categorySteps as $index => $category)
        @if ($step === $index + 2)
            <div class="space-y-6">
                <h3 class="text-lg font-semibold mb-4">
                    {{ strtoupper($category === 'import_tax' ? '🧾 Taxes d’import' : ($category === 'agency_fee' ? '🏢 Frais agence' : '🔧 Autres frais')) }}
                </h3>

                @foreach ($items as $i => $item)
                    @if ($item['category'] === $category)
                        <div class="grid grid-cols-6 gap-4 items-end mb-3">
                            @if ($category === 'import_tax')
                                <x-forms.select label="Taxe" :model="'items.' . $i . '.tax_id'" :options="$taxes" optionLabel="label"
                                    optionValue="id" />
                            @elseif ($category === 'agency_fee')
                                <x-forms.select label="Frais agence" :model="'items.' . $i . '.agency_fee_id'" :options="$agencyFees"
                                    optionLabel="label" optionValue="id" />
                            @elseif ($category === 'extra_fee')
                                <x-forms.select label="Frais divers" :model="'items.' . $i . '.extra_fee_id'" :options="$extraFees"
                                    optionLabel="label" optionValue="id" />
                            @endif

                            <x-forms.select label="Devise" :model="'items.' . $i . '.currency_id'" :options="$currencies" optionLabel="code"
                                optionValue="id" />

                            <x-forms.input label="Montant (devise locale)" :model="'items.' . $i . '.amount_local'" type="number"
                                step="0.01" />

                            <x-forms.input label="Montant USD" :model="'items.' . $i . '.amount_usd'" type="number" step="0.01"
                                disabled />

                            <x-forms.input label="Montant CDF" :model="'items.' . $i . '.amount_cdf'" type="number" step="0.01"
                                disabled />

                            <button wire:click.prevent="removeItem({{ $i }})"
                                class="text-red-600 text-sm">❌</button>
                        </div>
                    @endif
                @endforeach

                <button wire:click.prevent="addItem('{{ $category }}')"
                    class="text-sm text-blue-600 hover:underline">
                    ➕ Ajouter une ligne à
                    {{ $category === 'import_tax' ? 'Taxes' : ($category === 'agency_fee' ? 'Frais agence' : 'Frais divers') }}
                </button>

                <div class="pt-6 flex justify-between">
                    <button wire:click="previousStep"
                        class="px-6 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                        ← Retour
                    </button>
                    @if ($step < count($categorySteps) + 1)
                        <button wire:click="nextStep"
                            class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded hover:bg-indigo-700">
                            Étape suivante →
                        </button>
                    @else
                        <button wire:click="save"
                            class="px-6 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700">
                            💾 Enregistrer la facture
                        </button>
                    @endif
                </div>
            </div>
        @endif
    @endforeach
</div>
