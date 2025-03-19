<div>
    <main>
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6">
            <div x-data="{ pageName: `Créer un Dossier` }">
                <include src="./partials/breadcrumb.html" />
            </div>

            <div class="min-h-screen rounded-2xl border border-gray-200 bg-white px-5 py-7 dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-12">
                <main>
                    <div class="mx-auto max-w-screen-lg p-4 md:p-6">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Créer un Nouveau Dossier</h2>
                        <form wire:submit.prevent="submit" class="mt-6 grid grid-cols-2 gap-6">
                            
                            <!-- 🔹 Colonne Gauche -->
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium">Client</label>
                                    <select wire:model="client_id" class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                        <option value="">Sélectionner un client</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('client_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Fournisseur</label>
                                    <input type="text" wire:model="supplier" class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" required />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Type de Marchandise</label>
                                    <input type="text" wire:model="goods_type" class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" required />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Quantité</label>
                                    <input type="number" wire:model="quantity" class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" required />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Numéro du Manifeste</label>
                                    <input type="text" wire:model="manifest_number" class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Lieu de Livraison</label>
                                    <input type="text" wire:model="delivery_place" class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                </div>
                            </div>

                            <!-- 🔹 Colonne Droite -->
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium">Numéro de Dossier</label>
                                    <input type="text" wire:model="file_number" class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" required />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Numéro de Conteneur</label>
                                    <input type="text" wire:model="container_number" class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Plaque du Véhicule</label>
                                    <input type="text" wire:model="vehicle_plate" class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Type de Dossier</label>
                                    <input type="text" wire:model="file_type" class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" required />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Type de Contrat</label>
                                    <input type="text" wire:model="contract_type" class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" required />
                                </div>
                            </div>

                            <!-- 🔹 Bloc Groupé : FOB, Assurance, CIF, Poids -->
                            <div class="col-span-2 grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium">Valeur FOB ($)</label>
                                    <input type="number" step="0.01" wire:model="fob" class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" required />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Montant de l'Assurance ($)</label>
                                    <input type="number" step="0.01" wire:model="insurance" class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" required />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Poids Total (kg)</label>
                                    <input type="number" step="0.01" wire:model="total_weight" class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" required />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Devise</label>
                                    <input type="text" wire:model="currency" class="h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" required />
                                </div>
                            </div>

                            <div class="col-span-2 flex justify-end">
                                <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700">
                                    Enregistrer Dossier
                                </button>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </main>
</div>
