<div>
    <!-- FICHIERS -->
    <div x-show="tab === 'files'" x-cloak class="space-y-10">
        <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-lg space-y-6">

            <h4 class="text-lg font-semibold text-gray-800 dark:text-white">
                📄 Téléverser un document
            </h4>

            <!-- Type de document -->
            <div class="space-y-2">
                <label for="document_type" class="block text-sm text-gray-700 dark:text-gray-200 font-medium">
                    🗂️ Type de document
                </label>
                <x-forms.select
                    id="document_type"
                    wire:model.defer="documentType"
                    :options="$documentTypes"
                    option-label="name"
                    option-value="id"
                    placeholder="Sélectionnez un type de document"
                />
                @error('documentType')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input fichier -->
            <div class="space-y-2">
                <label for="fileInput" class="block text-sm text-gray-700 dark:text-gray-200 font-medium">
                    📂 Fichier à joindre
                </label>
                <div
                    class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center cursor-pointer hover:border-indigo-500 transition"
                    @drop.prevent
                    @dragover.prevent
                >
                    <input type="file" wire:model="file" id="fileInput" class="hidden">
                    <label for="fileInput" class="text-gray-600 dark:text-gray-300 text-sm cursor-pointer">
                        Glisser-déposer ou <span class="text-indigo-500 underline">choisir un fichier</span>
                    </label>
                </div>
                @error('file')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bouton d'envoi -->
            <div class="pt-2">
                <x-forms.button wire:click="uploadFile">
                    ➕ Ajouter le fichier
                </x-forms.button>
            </div>
        </div>

        <!-- Fichiers listés -->
        <div class="space-y-4">
            <h4 class="text-sm font-semibold text-gray-800 dark:text-white mb-2">📁 Fichiers joints</h4>
            @if ($folder->files && count($folder->files))
                <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    @foreach($folder->files as $file)
                        <li class="py-2 flex justify-between items-center">
                            <div class="flex flex-col gap-1">
                                <span class="text-gray-900 dark:text-white font-medium">{{ $file->name }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    Type : {{ $file->documentType->name ?? 'Non défini' }}
                                </span>
                            </div>
                            <button wire:click="deleteFile('{{ $file->id }}')" class="text-red-500 text-xs hover:underline">
                                Supprimer
                            </button>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400">Aucun fichier disponible.</p>
            @endif
        </div>
    </div>
</div>
