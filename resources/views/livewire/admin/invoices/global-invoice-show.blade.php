<div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-700">
                    Détails de la Facture Globale : <span class="text-blue-600">{{ $globalInvoice->global_invoice_number }}</span>
                </h1>
                <button
                    wire:click="downloadPdf"
                    class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75 transition duration-150 ease-in-out">
                    <svg wire:loading wire:target="downloadPdf" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="downloadPdf">Télécharger PDF</span>
                    <span wire:loading wire:target="downloadPdf">Téléchargement...</span>
                </button>
            </div>

            <div class="px-6 py-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Informations Générales</h3>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Numéro :</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $globalInvoice->global_invoice_number }}</dd>
                            </div>
                            @if($globalInvoice->company)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Compagnie :</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $globalInvoice->company->name }}</dd>
                            </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date d'Émission :</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $globalInvoice->issue_date->format('d/m/Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date d'Échéance :</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $globalInvoice->due_date ? $globalInvoice->due_date->format('d/m/Y') : 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Montant Total :</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ number_format($globalInvoice->total_amount, 2) }} {{-- Devise --}}</dd>
                            </div>
                        </dl>
                    </div>
                    @if($globalInvoice->notes)
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Notes :</h3>
                        <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-md">{{ nl2br(e($globalInvoice->notes)) }}</p>
                    </div>
                    @endif
                </div>

                <h3 class="text-xl font-semibold text-gray-700 mb-4 pt-4 border-t">Détails des Lignes de Facture Globale</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Unitaire</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($globalInvoice->globalInvoiceItems as $item)
                                <tr wire:key="item-{{ $item->id }}">
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray-800">{{ $item->description }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ number_format($item->quantity, 2) }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 text-right font-medium">{{ number_format($item->total_price, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">
                                        Aucun article trouvé pour cette facture globale.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right text-sm font-semibold text-gray-700 uppercase">Total Général :</td>
                                <td class="px-4 py-3 text-right text-sm font-bold text-gray-800">
                                    {{ number_format($globalInvoice->total_amount, 2) }} {{-- Devise --}}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Section Optionnelle: Factures Individuelles Incluses --}}
                @if ($globalInvoice->invoices->isNotEmpty())
                    <h3 class="text-xl font-semibold text-gray-700 mt-8 mb-4 pt-4 border-t">Factures Individuelles Incluses</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro Facture</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Facture</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Montant (USD)</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($globalInvoice->invoices as $invoice)
                                    <tr wire:key="invoice-{{ $invoice->id }}">
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-800">{{ $invoice->invoice_number }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $invoice->invoice_date->format('d/m/Y') }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ number_format($invoice->total_usd, 2) }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center">
                                            <a href="{{ route('admin.invoices.show', $invoice->id) }}" target="_blank" class="text-blue-600 hover:text-blue-900 font-medium">
                                                Voir Originale
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        <div class="mt-6">
            <a href="{{ route('admin.global-invoices.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                &larr; Retour à la liste des factures globales
            </a>
        </div>
    </div>
</div>
