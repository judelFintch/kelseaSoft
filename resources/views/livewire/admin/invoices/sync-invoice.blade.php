<div class="max-w-xl mx-auto p-6 space-y-6">
    <x-ui.flash-message />
    <x-ui.error-message />

    <div class="bg-white dark:bg-gray-800 border rounded-xl p-6 space-y-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
            Synchronisation Facture {{ $invoice->invoice_number }}
        </h2>
        <p>Total calculé depuis les lignes : <strong>{{ number_format($itemsTotal, 2) }} USD</strong></p>
        <p>Total enregistré : <strong>{{ number_format($invoice->total_usd, 2) }} USD</strong></p>

        @if($difference != 0)
            <div class="text-red-600">
                Différence détectée de {{ number_format($difference, 2) }} USD.
            </div>
            <x-forms.button type="button" wire:click="synchronize" class="mt-4">Synchroniser</x-forms.button>
        @else
            <div class="text-green-600">Aucune différence détectée.</div>
        @endif
    </div>
</div>
