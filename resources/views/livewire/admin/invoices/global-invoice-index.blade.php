<div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">Factures Globales</h1>
            <div class="flex items-center gap-2">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Rechercher (N°, Compagnie...)"
                    class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
                <select
                    wire:model.live="status"
                    class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                    <option value="">Tous</option>
                    <option value="paid">Payée</option>
                    <option value="pending">En attente</option>
                </select>
            </div>
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut de Paiement
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($globalInvoice->status === 'paid')
                                    <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs">Payée</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded-full text-xs">En attente</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <button @click="open = ! open" class="text-gray-600 hover:text-gray-900 font-medium">
                                        Actions
                                        <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                            <a href="{{ route('admin.global-invoices.show', $globalInvoice->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Voir Détails</a>
                                            <a href="{{ route('admin.global-invoices.edit', $globalInvoice->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Éditer</a>
                                            <button wire:click="confirmDeleteGlobalInvoice({{ $globalInvoice->id }})" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100" role="menuitem">🗑 Supprimer</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
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
            Tapez le numéro de la facture globale pour confirmer la suppression.
        </p>

        <div class="mt-6">
            <x-text-input id="confirm-delete-global" type="text" wire:model.defer="deleteConfirmText" class="mt-1 block w-3/4" placeholder="{{ $this->globalInvoiceToDelete?->global_invoice_number }}" />
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
