<div>
    <div>
        <div class="max-w-3xl mx-auto py-10 px-6 space-y-8">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Merchandise Types Management</h2>
    
            <!-- Flash Messages -->
            @if (session()->has('success'))
                <div class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
    
            <!-- Form -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form wire:submit.prevent="save" class="space-y-4">
                    <div>
                        <x-forms.input 
                            label="Merchandise Type Name" 
                            wire:model.live="name" 
                            placeholder="e.g., Electronics, Furniture, etc." 
                        />
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
    
                    <div class="flex items-center gap-3">
                        <x-forms.button type="submit">
                            {{ $editingId ? 'Update' : 'Add' }}
                        </x-forms.button>
                        @if ($editingId)
                            <button wire:click="$set('editingId', null)" type="button" class="text-sm text-gray-500 hover:underline">Cancel</button>
                        @endif
                        @if ($confirmingReset)
                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                Confirm reset?
                                <button wire:click="resetForm" class="ml-2 text-blue-500 hover:underline">Yes</button>
                                <button wire:click="$set('confirmingReset', false)" class="ml-2 text-gray-500 hover:underline">No</button>
                            </div>
                        @else
                            <button wire:click="confirmReset" type="button" class="text-sm text-gray-500 hover:underline">Reset All</button>
                        @endif
                    </div>
                </form>
            </div>
    
            <!-- Search -->
            <div>
                <x-forms.input 
                    wire:model.debounce.300ms="search" 
                    placeholder="🔍 Search merchandise type..." 
                    class="w-full"
                />
            </div>
    
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Name</th>
                            <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($types as $type)
                            <tr>
                                <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $type->name }}</td>
                                <td class="px-4 py-2 flex gap-3">
                                    <button wire:click="edit({{ $type->id }})" class="text-indigo-600 text-xs hover:underline">Edit</button>
                                    @if ($confirmingDelete === $type->id)
                                        <span class="text-sm text-gray-600 dark:text-gray-300">
                                            Confirm?
                                            <button wire:click="delete({{ $type->id }})" class="text-red-500 hover:underline ml-1">Yes</button>
                                            <button wire:click="$set('confirmingDelete', null)" class="text-gray-500 hover:underline ml-1">No</button>
                                        </span>
                                    @else
                                        <button wire:click="confirmDelete({{ $type->id }})" class="text-red-500 text-xs hover:underline">Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-4 text-gray-500 text-center">No merchandise types found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
    
            <div class="pt-4">
                {{ $types->links() }}
            </div>
        </div>
    </div>
    
</div>
