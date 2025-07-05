<div class="w-full mx-auto bg-white p-6 rounded-xl shadow space-y-6">
    <h2 class="text-xl font-bold">Gestion des caisses</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 px-3 py-2 rounded">{{ session('success') }}</div>
    @endif

    <div class="flex gap-4">
        <x-forms.input label="Nom" model="name" class="flex-1" />
        <x-forms.input label="Solde initial" type="number" model="balance" class="w-40" />
        <button wire:click="create" class="bg-brand-500 text-white px-4 py-2 rounded">Ajouter</button>
    </div>

    <table class="w-full mt-4 border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1 text-left">Nom</th>
                <th class="border px-2 py-1 text-right">Solde</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cashRegisters as $register)
                <tr>
                    <td class="border px-2 py-1">{{ $register->name }}</td>
                    <td class="border px-2 py-1 text-right">{{ number_format($register->balance, 2, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
