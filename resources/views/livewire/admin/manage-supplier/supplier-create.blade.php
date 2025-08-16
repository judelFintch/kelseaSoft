<div>
    <div class="max-w-5xl mx-auto p-6 space-y-6">
        @if (session()->has('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif

        <form wire:submit.prevent="save">
            <div class="bg-white border rounded-xl p-6 shadow-sm dark:bg-gray-800">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">
                    {{ $editingId ? '✏️ Update Supplier' : '➕ Add Supplier' }}
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-forms.input label="Supplier Name" wire:model="name" />
                    <x-forms.input label="Phone" wire:model="phone" />
                    <x-forms.input label="Email" wire:model="email" type="email" />
                    <x-forms.input label="Country" wire:model="country" />
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                            class="px-5 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-md focus:ring focus:ring-indigo-400 transition">
                        {{ $editingId ? '🔁 Update Supplier' : '💾 Add Supplier' }}
                    </button>

                    @if ($editingId)
                        <button type="button" wire:click="resetForm" class="text-sm text-gray-500 hover:underline">Cancel</button>
                    @endif

                    @if ($confirmingReset)
                        <span class="text-sm text-gray-600">Confirm reset?
                            <button wire:click="resetForm" class="ml-1 text-green-600 hover:underline">Yes</button>
                            <button wire:click="$set('confirmingReset', false)" class="ml-1 text-gray-600 hover:underline">No</button>
                        </span>
                    @else
                        <button type="button" wire:click="confirmReset" class="text-sm text-red-600 hover:underline">Reset All</button>
                    @endif
                </div>
            </div>
        </form>

        <div class="mt-6">
            <x-forms.input wire:model.debounce.300ms="search" placeholder="🔍 Search suppliers..." class="w-full" />
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Phone</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Country</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($suppliers as $supplier)
                        <tr>
                            <td class="px-4 py-2">{{ $supplier->name }}</td>
                            <td class="px-4 py-2">{{ $supplier->phone }}</td>
                            <td class="px-4 py-2">{{ $supplier->email }}</td>
                            <td class="px-4 py-2">{{ $supplier->country }}</td>
                            <td class="px-4 py-2 space-x-2">
                                <button wire:click="edit({{ $supplier->id }})" class="text-indigo-600 text-xs hover:underline">Edit</button>
                                @if ($confirmingDelete === $supplier->id)
                                    <span class="text-gray-600 text-sm">
                                        Confirm?
                                        <button wire:click="delete({{ $supplier->id }})" class="text-red-600 ml-1 hover:underline">Yes</button>
                                        <button wire:click="$set('confirmingDelete', null)" class="text-gray-600 ml-1 hover:underline">No</button>
                                    </span>
                                @else
                                    <button wire:click="confirmDelete({{ $supplier->id }})" class="text-red-600 text-xs hover:underline">Delete</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">No suppliers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>
