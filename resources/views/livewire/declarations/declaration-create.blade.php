<div>
    <div class="max-w-4xl mx-auto p-6 bg-white dark:bg-zinc-900 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Déclaration de marchandises</h2>
    
        <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-6">
    
            <!-- Numéro E -->
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Numéro E *</label>
                <input type="text" wire:model.defer="form.numero_e" class="w-full rounded-md border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" placeholder="Numéro sans la lettre E">
                @error('form.numero_e') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
    
            <!-- Date E -->
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date E *</label>
                <input type="date" wire:model.defer="form.date_e" class="w-full rounded-md border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                @error('form.date_e') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
    
            <!-- Importateur -->
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Importateur *</label>
                <select wire:model.defer="form.importateur_id" class="w-full rounded-md border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    <option value="">-- Choisir un importateur --</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                    @endforeach
                </select>
                @error('form.importateur_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
    
            <!-- Exportateur -->
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Exportateur</label>
                <select wire:model.defer="form.exportateur_id" class="w-full rounded-md border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    <option value="">-- Optionnel --</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                    @endforeach
                </select>
            </div>
    
            <!-- Régime -->
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Régime *</label>
                <input type="text" wire:model.defer="form.regime" class="w-full rounded-md border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                @error('form.regime') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
    
            <!-- Bureau de douane -->
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bureau de douane *</label>
                <input type="text" wire:model.defer="form.bureau_douane" class="w-full rounded-md border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                @error('form.bureau_douane') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
    
            <!-- Pays de provenance -->
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pays de provenance *</label>
                <input type="text" wire:model.defer="form.pays_provenance" class="w-full rounded-md border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                @error('form.pays_provenance') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
    
            <!-- Pays de destination -->
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pays de destination *</label>
                <input type="text" wire:model.defer="form.pays_destination" class="w-full rounded-md border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                @error('form.pays_destination') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
    
            <!-- Taux de change -->
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Taux de change</label>
                <input type="number" step="0.0001" wire:model.defer="form.taux_change" class="w-full rounded-md border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
            </div>
    
            <!-- Déclarant -->
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Déclarant</label>
                <select wire:model.defer="form.declarant_id" class="w-full rounded-md border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    <option value="">-- Choisir un utilisateur --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
    
            <!-- Numéro de conteneur -->
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Numéro de conteneur</label>
                <input type="text" wire:model.defer="form.numero_conteneur" class="w-full rounded-md border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
            </div>
    
            <!-- Notes -->
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                <textarea wire:model.defer="form.notes" rows="3" class="w-full rounded-md border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"></textarea>
            </div>
    
            <!-- Bouton -->
            <div class="col-span-1 md:col-span-2 text-right">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
    
</div>
