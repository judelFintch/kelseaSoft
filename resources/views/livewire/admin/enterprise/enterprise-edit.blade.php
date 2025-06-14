<div class="w-full mx-auto bg-white p-6 rounded-xl shadow space-y-6">
    <h2 class="text-xl font-bold">🏢 Établissement</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 px-3 py-2 rounded">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-forms.input label="Nom" model="name" />
        <x-forms.input label="Slogan" model="tagline" />
        <x-forms.input label="N° Impôt" model="tax_id" />
        <x-forms.input label="RCCM" model="commercial_register" />
        <x-forms.input label="ID National" model="national_identification" />
        <x-forms.input label="N° Agrément" model="agreement_number" />
        <x-forms.input label="Téléphone" model="phone_number" />
        <x-forms.input label="Email" model="email" type="email" />
        <x-forms.input label="Adresse" model="physical_address" />
        <x-forms.input label="Note pied de page" model="footer_note" />
        <x-forms.input label="Logo (URL)" model="logo" />
    </div>

    <button wire:click="save" class="bg-blue-600 text-white px-4 py-2 rounded">💾 Enregistrer</button>
</div>
