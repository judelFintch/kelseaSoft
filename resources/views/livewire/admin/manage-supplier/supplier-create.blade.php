<div>
    <div x-data="{ step: 1 }">
        <x-ui.flash-message />
        <x-ui.error-message />
    
        <div class="max-w-5xl mx-auto p-6">
            <form wire:submit.prevent="save()">
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-5 py-4 sm:px-6 sm:py-5">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">Manage Supplier</h3>
                    </div>
    
                    <div class="divide-y divide-gray-100 p-5 sm:p-6 dark:divide-gray-800">
                        <div class="pb-5">
                            <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Supplier Details</h4>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <x-forms.input label="Supplier Name" wire:model.live="name" placeholder="e.g., Global Transit SARL" />
                                <x-forms.input label="Phone" wire:model.live="phone" placeholder="e.g., +243812345678" />
                                <x-forms.input label="Email" wire:model.live="email" type="email" placeholder="e.g., contact@supplier.com" />
                                <x-forms.input label="Country" wire:model.live="country" placeholder="e.g., DR Congo" />
                            </div>
                        </div>
                    </div>
    
                    <div class="flex justify-end items-center px-5 py-4 sm:px-6 sm:py-5">
                        <x-forms.button type="submit">
                            {{ $editingId ? 'Update Supplier' : 'Add Supplier' }}
                        </x-forms.button>
                    </div>
                </div>
            </form>
        
            <x-forms.input 
                wire:model.debounce.300ms="search" 
                placeholder="🔍 Search supplier..." 
                class="w-full"
            />
        

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Name</th>
                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Phone</th>
                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Email</th>
                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Country</th>
                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($suppliers as $supplier)
                        <tr>
                            <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $supplier->name }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $supplier->phone }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $supplier->email }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $supplier->country }}</td>
                            <td class="px-4 py-2 flex gap-3">
                                <button wire:click="edit({{ $supplier->id }})" class="text-indigo-600 text-xs hover:underline">Edit</button>
                                @if ($confirmingDelete === $supplier->id)
                                    <span class="text-sm text-gray-600 dark:text-gray-300">
                                        Confirm?
                                        <button wire:click="delete({{ $supplier->id }})" class="text-red-500 hover:underline ml-1">Yes</button>
                                        <button wire:click="$set('confirmingDelete', null)" class="text-gray-500 hover:underline ml-1">No</button>
                                    </span>
                                @else
                                    <button wire:click="confirmDelete({{ $supplier->id }})" class="text-red-500 text-xs hover:underline">Delete</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-gray-500 text-center">No suppliers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-4">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>
