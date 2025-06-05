<div>
    <h2 class="text-xl font-semibold mb-4">Créer un agent</h2>
    <form wire:submit.prevent="createAgent" class="space-y-4">
        <div>
            <label class="block mb-1">Nom</label>
            <input type="text" wire:model="name" class="border rounded px-2 py-1 w-full" />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block mb-1">Email</label>
            <input type="email" wire:model="email" class="border rounded px-2 py-1 w-full" />
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block mb-1">Téléphone</label>
            <input type="text" wire:model="phone" class="border rounded px-2 py-1 w-full" />
        </div>
        <div>
            <label class="block mb-1">Adresse</label>
            <input type="text" wire:model="address" class="border rounded px-2 py-1 w-full" />
        </div>
        <div>
            <label class="block mb-1">Poste</label>
            <input type="text" wire:model="position" class="border rounded px-2 py-1 w-full" />
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Enregistrer</button>
    </form>
</div>
