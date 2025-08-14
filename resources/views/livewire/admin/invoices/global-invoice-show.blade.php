<div class="relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <h1 class="text-3xl font-bold">
                        Détails de la Facture Globale :
                        <span class="text-yellow-300">{{ $globalInvoice->global_invoice_number }}</span>
                    </h1>
                    <div class="flex flex-wrap justify-end gap-3">
                        <button wire:click="downloadPdf1" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75 transition duration-150 ease-in-out">
                            <svg wire:loading wire:target="downloadPdf1" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.82 4 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="downloadPdf1">Frais et Taxes</span>
                            <span wire:loading wire:target="downloadPdf1">Téléchargement...</span>
                        </button>

                        <button wire:click="downloadPdf2" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75 transition duration-150 ease-in-out">
                            <svg wire:loading wire:target="downloadPdf2" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.82 4 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="downloadPdf2">Honoraire</span>
                            <span wire:loading wire:target="downloadPdf2">Téléchargement...</span>
                        </button>

                        <button wire:click="downloadPdf3" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75 transition duration-150 ease-in-out">
                            <svg wire:loading wire:target="downloadPdf3" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.82 4 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="downloadPdf3">Facture complète</span>
                            <span wire:loading wire:target="downloadPdf3">Téléchargement...</span>
                        </button>

                        <a href="{{ route('admin.global-invoices.edit', $globalInvoice->id) }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 transition duration-150 ease-in-out">
                            Éditer
                        </a>

                        <button wire:click="exportSummary" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition duration-150 ease-in-out">
                            <svg wire:loading wire:target="exportSummary" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.82 4 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="exportSummary">Exporter Excel</span>
                            <span wire:loading wire:target="exportSummary">Export...</span>
                        </button>

                        @if ($globalInvoice->status === 'paid')
                            <button wire:click="markAsPending" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-opacity-75 transition duration-150 ease-in-out">
                                Marquer comme en attente
                            </button>
                        @else
                            <button wire:click="markAsPaid" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-opacity-75 transition duration-150 ease-in-out">
                                Marquer comme payée
                            </button>
                        @endif
                    </div>
                </div>

                <div class="mt-4 space-y-2">
                    {{-- Barre de progression lors de la génération du PDF 1 --}}
                    <div wire:loading wire:target="downloadPdf1">
                        <div class="w-full bg-white/20 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-green-400 h-2.5 rounded-full animate-pulse w-full"></div>
                        </div>
                        <p class="text-xs text-white mt-1">Génération du PDF...</p>
                    </div>

                    {{-- Barre de progression lors de la génération du PDF 2 --}}
                    <div wire:loading wire:target="downloadPdf2">
                        <div class="w-full bg-white/20 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-green-400 h-2.5 rounded-full animate-pulse w-full"></div>
                        </div>
                        <p class="text-xs text-white mt-1">Génération du PDF...</p>
                    </div>

                    {{-- Barre de progression lors de la génération du PDF 3 --}}
                    <div wire:loading wire:target="downloadPdf3">
                        <div class="w-full bg-white/20 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-green-400 h-2.5 rounded-full animate-pulse w-full"></div>
                        </div>
                        <p class="text-xs text-white mt-1">Génération du PDF...</p>
                    </div>

                    {{-- Barre de progression lors de l'export Excel --}}
                    <div wire:loading wire:target="exportSummary">
                        <div class="w-full bg-white/20 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-blue-400 h-2.5 rounded-full animate-pulse w-full"></div>
                        </div>
                        <p class="text-xs text-white mt-1">Génération de l'Excel...</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-2 flex items-center gap-2"><span>ℹ️</span> Informations Générales</h3>
                        <dl class="bg-gray-50 p-4 rounded-lg shadow grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Numéro :</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $globalInvoice->global_invoice_number }}</dd>
                            </div>
                            @if ($globalInvoice->company)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Compagnie :</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $globalInvoice->company->name }}</dd>
                                </div>
                            @endif
                            @if ($globalInvoice->product)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Produit :</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $globalInvoice->product }}</dd>
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
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Statut :</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($globalInvoice->status) }}</dd>
                            </div>
                        </dl>
                    </div>
                    @if ($globalInvoice->notes)
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-800 mb-2 flex items-center gap-2"><span>📝</span> Notes :</h3>
                            <p class="text-sm text-gray-700 bg-white p-4 rounded-lg shadow">
                                {{ nl2br(e($globalInvoice->notes)) }}</p>
                        </div>
                    @endif
                </div>

                <h3 class="text-xl font-semibold text-gray-700 mb-4 pt-4 border-t">Détails des Lignes de Facture Globale
                </h3>
                @php
                    $folders = $globalInvoice->invoices->load('folder')->pluck('folder')->filter();
                    $declarationCount = $folders->filter(fn($f) => !empty($f->truck_number))->count();
                    $truckCount = $folders->filter(fn($f) => !empty($f->truck_number))->unique('truck_number')->count();
                    $scelleQty = $globalInvoice->globalInvoiceItems
                        ->filter(fn($i) => str_contains(strtolower($i->description), 'scelle'))
                        ->sum('quantity');
                    $nacQty = $globalInvoice->globalInvoiceItems
                        ->filter(fn($i) => str_contains(strtolower($i->description), 'nac'))
                        ->sum('quantity');
                @endphp
                <table class="min-w-full text-sm mb-4 rounded-lg overflow-hidden shadow">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-2 py-1">Déclaration</th>
                            <th class="px-2 py-1">Truck</th>
                            <th class="px-2 py-1">Scellés</th>
                            <th class="px-2 py-1">NAC</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="text-center">
                            <td class="px-2 py-1">{{ $declarationCount }}</td>
                            <td class="px-2 py-1">{{ $truckCount }}</td>
                            <td class="px-2 py-1">{{ $scelleQty }} </td>
                            <td class="px-2 py-1">{{ $nacQty }} </td>
                        </tr>
                    </tbody>
                </table>
                @foreach (['import_tax' => 'A. IMPORT DUTY & TAXES', 'agency_fee' => 'B. AGENCY FEES', 'extra_fee' => 'C. AUTRES FRAIS'] as $cat => $label)
                    @php $items = $globalInvoice->globalInvoiceItems->where('category', $cat); @endphp
                    @if ($items->count())
                        <div class="overflow-x-auto border-t pt-4">
                            <h2 class="text-lg font-semibold mb-2">{{ $label }}</h2>
                            <table class="min-w-full text-sm mb-2 rounded-lg overflow-hidden shadow">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-2 py-1">Réf.</th>
                                        <th class="px-2 py-1">Libellé</th>
                                        <th class="px-2 py-1 text-right">Qté</th>

                                        <th class="px-2 py-1 text-right">Total (USD)</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @foreach ($items as $item)
                                        <tr>
                                            <td class="px-2 py-1">{{ $item->ref_code }}</td>
                                            <td class="px-2 py-1">{{ $item->description }}</td>
                                            <td class="px-2 py-1 text-right">
                                                {{ number_format($item->quantity, 2) }}</td>

                                            <td class="px-2 py-1 text-right">
                                                {{ number_format($item->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-gray-50">
                                        <td colspan="3" class="px-2 py-1 text-right font-semibold">Sous-total
                                        </td>
                                        <td class="px-2 py-1 text-right font-semibold">
                                            {{ number_format($items->sum('total_price'), 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endforeach
                <div class="border-t pt-4">
                    <table class="w-full text-sm">
                        <tr>
                            <td class="text-right font-semibold pr-4">Total Général (USD) :</td>
                            <td class="text-right font-bold text-lg text-gray-800">
                                {{ number_format($globalInvoice->total_amount, 2) }}</td>
                        </tr>
                    </table>
                </div>

                {{-- Section Optionnelle: Factures Individuelles Incluses --}}
                @if ($globalInvoice->invoices->isNotEmpty())
                    <h3 class="text-xl font-semibold text-gray-700 mt-8 mb-4 pt-4 border-t">Factures Individuelles
                        Incluses</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full rounded-lg overflow-hidden shadow">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro Facture</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Facture</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Montant (USD)</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y">
                                @foreach ($globalInvoice->invoices as $invoice)
                                    <tr wire:key="invoice-{{ $invoice->id }}" class="hover:bg-gray-50">
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-800">
                                            {{ $invoice->invoice_number }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $invoice->invoice_date->format('d/m/Y') }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                            {{ number_format($invoice->total_usd, 2) }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center">
                                            <a href="{{ route('invoices.show', $invoice->id) }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-900 font-medium">
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
            <a href="{{ route('admin.global-invoices.index') }}"
                class="text-blue-600 hover:text-blue-800 font-medium">
                &larr; Retour à la liste des factures globales
            </a>
        </div>
    </div>
</div>
