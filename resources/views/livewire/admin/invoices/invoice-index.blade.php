<div>
<div class="w-full max-w-6xl mx-auto p-6 bg-white rounded-xl shadow space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold">📋 Factures Générées</h2>
        <div class="flex space-x-2">
            <input type="text" wire:model.live.debounce.500ms="search" placeholder="🔍 Rechercher..."
                class="border rounded px-3 py-1 text-sm" />
            <input type="text" wire:model.live.debounce.500ms="filterCode" placeholder="Code"
                class="border rounded px-3 py-1 text-sm" />
            <input type="date" wire:model.live="filterDate" class="border rounded px-3 py-1 text-sm" />
        </div>
    </div>

    {{-- Notifications Flash --}}
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Bouton de création de facture globale --}}
    @if (count($selectedInvoices) > 0)
        <div class="my-4">
            <button wire:click="createGlobalInvoice"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Générer Facture Globale ({{ count($selectedInvoices) }} sélectionnée(s))
            </button>
            <span wire:loading wire:target="createGlobalInvoice" class="ml-2 text-sm text-gray-600">Création en
                cours...</span>
            @if ($companyIdForGlobalInvoice)
                <span class="ml-2 text-sm text-gray-500">
                    Pour la compagnie ID: {{ $companyIdForGlobalInvoice }}
                    ({{ \App\Models\Company::notDeleted()->find($companyIdForGlobalInvoice)?->name ?? 'N/A' }})
                </span>
            @endif
        </div>
    @endif

    <table class="w-full border mt-4 text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1 w-10">
                    {{-- Optionnel: Case à cocher "Tout sélectionner" --}}
                </th>
                <th class="border px-2 py-1">#</th>
                <th class="border px-2 py-1">Facture</th>
                <th class="border px-2 py-1">Date</th>
                <th class="border px-2 py-1">Client</th>
                <th class="border px-2 py-1 text-right">Total (USD)</th>
                <th class="border px-2 py-1">Statut Global</th>
                <th class="border px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoices as $invoice)
                <tr>

                <tr
                    class="{{ $invoice->global_invoice_id ? 'bg-green-50' : '' }} {{ in_array($invoice->id, $selectedInvoices) ? 'bg-yellow-50' : '' }}">
                    <td class="border px-2 py-1 text-center">
                        <input type="checkbox" wire:model.live="selectedInvoices" value="{{ $invoice->id }}"
                            {{ $invoice->global_invoice_id !== null ? 'disabled' : '' }}
                            class="rounded border-gray-300">
                    </td>
                    <td class="border px-2 py-1">{{ $loop->iteration }}</td>
                    <td class="border px-2 py-1 font-semibold">{{ $invoice->invoice_number }}</td>
                    <td class="border px-2 py-1">{{ $invoice->invoice_date->format('d/m/Y') }}</td>
                    <td class="border px-2 py-1">{{ $invoice->company->name }}
                        @if (
                            $companyIdForGlobalInvoice &&
                                $invoice->company_id !== $companyIdForGlobalInvoice &&
                                in_array($invoice->id, $selectedInvoices))
                            <span class="text-red-500 text-xs">(Ne correspond pas à la Cie. sélectionnée)</span>
                        @endif
                    </td>
                    <td class="border px-2 py-1 text-right">{{ number_format($invoice->total_usd, 2) }}</td>
                    <td class="border px-2 py-1 text-center">
                        @if ($invoice->global_invoice_id)
                            <span class="text-xs px-2 py-1 bg-green-200 text-green-800 rounded-full">
                                Groupée (#{{ $invoice->globalInvoice?->global_invoice_number }})
                            </span>
                        @else
                            <span class="text-xs px-2 py-1 bg-gray-200 text-gray-800 rounded-full">
                                Non groupée
                            </span>
                        @endif
                    </td>
                    <td class="border px-2 py-1 text-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="text-gray-500 hover:text-gray-700">•••</button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('invoices.show', $invoice->id)">Voir</x-dropdown-link>
                                <x-dropdown-link :href="route('invoices.invoices.edit', $invoice->id)">Modifier</x-dropdown-link>
                                <x-dropdown-link :href="route('invoices.items.add', $invoice->id)" class="text-blue-600 hover:text-blue-800">Ajouter éléments</x-dropdown-link>
                                <button wire:click="confirmDeleteInvoice({{ $invoice->id }})"
                                    class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Archiver
                                </button>
                                <button wire:click="exportPdf({{ $invoice->id }})"
                                    class="w-full text-left block px-4 py-2 text-sm text-green-600 hover:bg-gray-100">
                                    PDF
                                </button>
                            </x-slot>
                        </x-dropdown>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-4">Aucune facture trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $invoices->links() }}
    </div>
</div>

<x-modal name="confirm-invoice-deletion" focusable>
    <form wire:submit.prevent="deleteInvoice" class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Confirmer la suppression de la facture
            {{ $this->invoiceToDelete?->invoice_number }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Tapez \"SUPPRIMER\" pour confirmer la suppression.
        </p>

        <div class="mt-6">
            <x-text-input id="confirm-delete" type="text" wire:model.defer="deleteConfirmText" class="mt-1 block w-3/4" placeholder="SUPPRIMER" />
            <x-input-error :messages="$errors->get('deleteConfirmText')" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Delete') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
</div>
