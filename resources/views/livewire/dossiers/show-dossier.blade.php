<div class="p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-800">Détails du Dossier</h2>
    @if (session()->has('error'))
        <div class="text-red-500 text-sm">
            {{ session('error') }}
        </div>
    @else
        <div class="mt-4">
            <p><strong>Numéro du dossier:</strong> {{ $dossier->file_number }}</p>
            <p><strong>Client:</strong> {{ $dossier->client->company_name ?? 'N/A' }}</p>
            <p><strong>Fournisseur:</strong> {{ $dossier->supplier }}</p>
            <p><strong>Type de Marchandise:</strong> {{ $dossier->goods_type }}</p>
            <p><strong>Quantité:</strong> {{ $dossier->quantity }}</p>
            <p><strong>Valeur Déclarée:</strong> ${{ number_format($dossier->declared_value, 2) }}</p>
            <p><strong>Date d'Arrivée Estimée:</strong> {{ $dossier->expected_arrival_date }}</p>
            <p><strong>Statut:</strong>
                <span
                    class="px-2 py-1 rounded-lg {{ $dossier->status == 'pending' ? 'bg-yellow-500' : ($dossier->status == 'validated' ? 'bg-blue-500' : 'bg-green-500') }} text-white">
                    {{ ucfirst($dossier->status) }}
                </span>
            </p>
        </div>

        <!-- 🔹 Formulaire pour modifier le nom du dossier -->
        <div class="mt-4 flex items-center gap-4">
            <input type="text" wire:model="folderName" placeholder="Nom du Dossier"
                class="border rounded-lg px-3 py-2 text-gray-700 w-full">
            <button wire:click="updateDossier" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Modifier
            </button>
        </div>
        @error('folderName')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror

        <!-- 🔹 Zone de téléversement de fichiers -->
        <h3 class="mt-6 text-lg font-semibold">Ajouter des fichiers</h3>

        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center" ondrop="handleDrop(event)"
            ondragover="event.preventDefault()">
            <p class="text-gray-600">Déposez vos fichiers ici ou cliquez pour sélectionner</p>
            <input type="file" wire:model="files" multiple class="hidden" id="fileInput">
            <button onclick="document.getElementById('fileInput').click()"
                class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Sélectionner des fichiers
            </button>
        </div>

        <!-- 🔹 Affichage des fichiers sélectionnés avant envoi -->
        @if ($files)
            <h4 class="mt-4 text-md font-semibold">Fichiers sélectionnés :</h4>
            <ul class="mt-2">
                @foreach ($files as $index => $file)
                    <li class="flex justify-between items-center text-sm text-gray-700 border-b py-2">
                        {{ $file->getClientOriginalName() }}
                        <button wire:click="removeFile({{ $index }})"
                            class="text-red-600 hover:underline">Supprimer</button>
                    </li>
                @endforeach
            </ul>
        @endif
        <button wire:click="submitFiles" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            Confirmer le Téléversement
        </button>
        <!-- 🔹 Bouton Upload -->
        <button wire:click="uploadFiles" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            Télécharger les fichiers
        </button>

        <!-- 🔹 Affichage des fichiers enregistrés -->
        <h4 class="mt-6 text-lg font-semibold">Fichiers enregistrés :</h4>
        @if ($uploadedFiles->isEmpty())
            <p class="text-gray-500">Aucun fichier enregistré.</p>
        @else
            <ul class="mt-2">
                @foreach ($uploadedFiles as $file)
                    <li class="flex justify-between text-sm text-gray-700 border-b py-2">
                        <a href="{{ Storage::url($file->path) }}" target="_blank"
                            class="text-blue-600 hover:underline">
                            {{ $file->name }}
                        </a>
                        <button wire:click="deleteFile({{ $file->id }})" class="text-red-600 hover:underline">
                            Supprimer
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif
    @endif

    <div class="mt-6">
        <a href="{{ route('dossiers.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            Retour à la liste
        </a>
    </div>
</div>

<script>
    function handleDrop(event) {
        event.preventDefault();
        document.getElementById('fileInput').files = event.dataTransfer.files;
    }
</script>
