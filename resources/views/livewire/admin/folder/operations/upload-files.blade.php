<div>
    <!-- FICHIERS -->
    <div x-show="tab === 'files'" x-cloak class="space-y-10">
        <!-- Message flash -->
        @if (session()->has('success'))
            <div class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 p-3 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 p-3 rounded text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>❗ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-lg space-y-6">

            <h4 class="text-lg font-semibold text-gray-800 dark:text-white">
                📄 Téléverser un document
            </h4>

            <!-- Type de document -->
            <div class="space-y-2">
                <label for="document_type" class="block text-sm text-gray-700 dark:text-gray-200 font-medium">
                    🗂️ Type de document
                </label>
                <x-forms.select id="document_type" wire:model.live="documentType" :options="$documentTypes" option-label="name"
                    option-value="id" placeholder="Sélectionnez un type de document" />
                @error('documentType')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input fichier -->
            <div class="space-y-2">
                <label for="fileInput" class="block text-sm text-gray-700 dark:text-gray-200 font-medium">
                    📂 Fichier à joindre
                </label>
                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center cursor-pointer hover:border-indigo-500 transition relative"
                    @drop.prevent @dragover.prevent>
                    <input type="file" wire:model="file" id="fileInput"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <label for="fileInput"
                        class="text-gray-600 dark:text-gray-300 text-sm cursor-pointer relative z-10">
                        Glisser-déposer ou <span class="text-indigo-500 underline">choisir un fichier</span>
                    </label>
                </div>
                @error('file')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <!-- Aperçu image (si image) -->
                @if ($file && Str::startsWith($file->getMimeType(), 'image/'))
                    <div class="mt-4">
                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-1">Aperçu :</p>
                        <img src="{{ $file->temporaryUrl() }}" class="w-48 rounded shadow border">
                    </div>
                @endif
            </div>

            <!-- Bouton d'envoi -->
            <div class="pt-2">
                <x-forms.button wire:click="uploadFile">
                    ➕ Ajouter le fichier
                </x-forms.button>
            </div>
        </div>

        <!-- Fichiers listés par type dans un tableau -->
        <div class="space-y-6">
            <h4 class="text-sm font-semibold text-gray-800 dark:text-white mb-2">📁 Fichiers joints par type</h4>
            @php
                $grouped = $folder->files->groupBy(fn($f) => $f->documentType->name ?? 'Non défini');
            @endphp

            @if ($grouped->count())
                @foreach ($grouped as $type => $files)
                    <div>
                        <h5 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            🗂️ {{ $type }}
                        </h5>
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto text-sm border border-gray-200 dark:border-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Nom du fichier
                                        </th>
                                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Aperçu</th>
                                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @php $i = 1; @endphp
                                    @foreach ($files as $file)
                                        <tr>
                                            <td class="px-4 py-2">
                                                <a href="{{ asset('storage/' . $file->path) }}" target="_blank"
                                                    class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                                    {{ $i++ }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-2">
                                                @if (Str::startsWith(pathinfo($file->path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                                    <img src="{{ asset('storage/' . $file->path) }}"
                                                        class="w-16 h-16 object-cover rounded">
                                                @else
                                                    <span class="text-xs text-gray-400">(non affichable)</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 flex gap-3">
                                                <a href="{{ asset('storage/' . $file->path) }}" target="_blank"
                                                    class="text-blue-500 text-xs hover:underline">Télécharger</a>
                                                <button wire:click="deleteFile({{ $file->id }})"
                                                    class="text-red-500 text-xs hover:underline">Supprimer</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400">Aucun fichier disponible.</p>
            @endif
        </div>
    </div>
</div>
