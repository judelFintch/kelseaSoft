<div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">Factures Globales</h1>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Rechercher (N°, Compagnie...)"
                class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            />
        </div>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Numéro
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Compagnie
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date d'Émission
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Montant Total
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($globalInvoices as $globalInvoice)
                        <tr wire:key="{{ $globalInvoice->id }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $globalInvoice->global_invoice_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $globalInvoice->company?->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $globalInvoice->issue_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                {{ number_format($globalInvoice->total_amount, 2) }} {{-- Supposant que la devise est cohérente ou gérée ailleurs --}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                <a href="{{ route('admin.global-invoices.show', $globalInvoice->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                    Voir Détails
                                </a>
                                <button wire:click="confirmDeleteGlobalInvoice({{ $globalInvoice->id }})"
                                        class="text-red-600 hover:underline text-sm cursor-pointer">
                                    🗑 Supprimer
                                </button>
                                {{-- Possibilité d'ajouter d'autres actions comme "Télécharger PDF" directement ici --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                Aucune facture globale trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($globalInvoices->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $globalInvoices->links() }}
                </div>
            @endif
        </div>
    </div>

<x-modal name="confirm-global-invoice-deletion" focusable>
    <form wire:submit.prevent="deleteGlobalInvoice" class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Confirmer la suppression de la facture globale
            {{ $this->globalInvoiceToDelete?->global_invoice_number }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Tapez \"SUPPRIMER\" pour confirmer la suppression.
        </p>

        <div class="mt-6">
            <x-text-input id="confirm-delete-global" type="text" wire:model.defer="deleteConfirmText" class="mt-1 block w-3/4" placeholder="SUPPRIMER" />
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
