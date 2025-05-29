<div class="mt-6 space-y-4">
    <h3 class="text-lg font-semibold">🧾 Lignes de facture</h3>

    @foreach ($items as $index => $item)
        <div class="grid grid-cols-6 gap-2 items-end">
            <x-forms.select label="Catégorie" model="items.{{ $index }}.category">
                <option value="import_tax">Taxe d'import</option>
                <option value="agency_fee">Frais d'agence</option>
                <option value="extra_fee">Autres frais</option>
            </x-forms.select>

            @if ($item['category'] === 'import_tax')
                <x-forms.select label="Taxe" model="items.{{ $index }}.tax_id">
                    <option value="">-- choisir --</option>
                    @foreach($taxes as $tax)
                        <option value="{{ $tax->id }}">{{ $tax->code }} - {{ $tax->label }}</option>
                    @endforeach
                </x-forms.select>
            @elseif ($item['category'] === 'agency_fee')
                <x-forms.select label="Frais agence" model="items.{{ $index }}.agency_fee_id">
                    <option value="">-- choisir --</option>
                    @foreach($agencyFees as $fee)
                        <option value="{{ $fee->id }}">{{ $fee->label }}</option>
                    @endforeach
                </x-forms.select>
            @elseif ($item['category'] === 'extra_fee')
                <x-forms.select label="Frais divers" model="items.{{ $index }}.extra_fee_id">
                    <option value="">-- choisir --</option>
                    @foreach($extraFees as $fee)
                        <option value="{{ $fee->id }}">{{ $fee->label }}</option>
                    @endforeach
                </x-forms.select>
            @endif

            <x-forms.input label="Montant (USD)" model="items.{{ $index }}.amount_usd" type="number" step="0.01" />
            <button wire:click.prevent="removeItem({{ $index }})" class="text-red-600 text-sm mt-2">❌</button>
        </div>
    @endforeach

    <button wire:click.prevent="addItem" class="text-sm text-blue-700 mt-2 hover:underline">➕ Ajouter une ligne</button>

    <div class="text-right mt-4 text-lg font-bold">
        Total : {{ number_format($this->total_usd, 2) }} USD
    </div>
</div>
