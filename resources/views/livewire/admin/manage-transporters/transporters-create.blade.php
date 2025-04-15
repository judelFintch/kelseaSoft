<div>
    <div>
        <div class="max-w-5xl mx-auto py-10 px-6 space-y-8">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Transporters Management</h2>
    
            @if (session()->has('success'))
                <div class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
    
            <form wire:submit.prevent="save()">
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-5 py-4 sm:px-6 sm:py-5">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">Create Transporter</h3>
                    </div>
    
                    <div class="divide-y divide-gray-100 p-5 sm:p-6 dark:divide-gray-800">
                        <div class="pb-5">
                            <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Transporter Details</h4>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <x-forms.input label="Name" wire:model.live="name" placeholder="e.g., Transco" />
                                <x-forms.input label="Phone" wire:model.live="phone" placeholder="e.g., +243812345678" />
                                <x-forms.input label="Email" wire:model.live="email" type="email" placeholder="e.g., contact@transco.com" />
                                <x-forms.input label="Country" wire:model.live="country" placeholder="e.g., DR Congo" />
                            </div>
                        </div>
                    </div>
    
                    <div class="flex justify-end items-center px-5 py-4 sm:px-6 sm:py-5">
                        <x-forms.button type="submit">
                            {{ $editingId ? 'Update' : 'Add' }}
                        </x-forms.button>
                        @if ($editingId)
                            <button wire:click="$set('editingId', null)" type="button" class="text-sm text-gray-500 hover:underline ml-3">Cancel</button>
                        @endif
                        @if ($confirmingReset)
                            <div class="text-sm text-gray-600 dark:text-gray-300 ml-4">
                                Confirm reset?
                                <button wire:click="resetForm" class="ml-2 text-blue-500 hover:underline">Yes</button>
                                <button wire:click="$set('confirmingReset', false)" class="ml-2 text-gray-500 hover:underline">No</button>
                            </div>
                        @else
                            <button wire:click="confirmReset" type="button" class="text-sm text-gray-500 hover:underline ml-4">Reset All</button>
                        @endif
                    </div>
                </div>
            </form>
    
            <div class="pt-6">
                <x-forms.input 
                    wire:model.debounce.300ms="search" 
                    placeholder="🔍 Search transporter..." 
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600" 
                />
            </div>
    
            <div class="overflow-x-auto rounded-lg shadow-sm">
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
                        @forelse($transporters as $transporter)
                            <tr>
                                <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $transporter->name }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $transporter->phone }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $transporter->email }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $transporter->country }}</td>
                                <td class="px-4 py-2 flex gap-3">
                                    <button wire:click="edit({{ $transporter->id }})" class="text-indigo-600 text-xs hover:underline">Edit</button>
                                    @if ($confirmingDelete === $transporter->id)
                                        <span class="text-sm text-gray-600 dark:text-gray-300">
                                            Confirm?
                                            <button wire:click="delete({{ $transporter->id }})" class="text-red-500 hover:underline ml-1">Yes</button>
                                            <button wire:click="$set('confirmingDelete', null)" class="text-gray-500 hover:underline ml-1">No</button>
                                        </span>
                                    @else
                                        <button wire:click="confirmDelete({{ $transporter->id }})" class="text-red-500 text-xs hover:underline">Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-gray-500 text-center">No transporters found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
    
            <div class="pt-4">
                {{ $transporters->links() }}
            </div>
        </div>
    </div>
</div>
