<div>
    <div class="max-w-5xl mx-auto py-10 px-6 space-y-8">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">🚛 Transporters Management</h2>

        @if (session()->has('success'))
            <div class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire -->
        <form wire:submit.prevent="save">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                        {{ $editingId ? '✏️ Edit Transporter' : '➕ Create Transporter' }}
                    </h3>
                </div>

                <div class="divide-y divide-gray-100 p-5 sm:p-6 dark:divide-gray-800">
                    <div class="pb-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Transporter Details</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <x-forms.input label="Name" wire:model="name" placeholder="e.g., Transco" />
                            <x-forms.input label="Phone" wire:model="phone" placeholder="e.g., +243812345678" />
                            <x-forms.input label="Email" wire:model="email" type="email" placeholder="e.g., contact@transco.com" />
                            <x-forms.input label="Country" wire:model="country" placeholder="e.g., DR Congo" />
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap justify-end items-center gap-3 px-5 py-4 sm:px-6 sm:py-5">
                    <button type="submit"
                            class="px-6 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        {{ $editingId ? '🔁 Update' : '💾 Add' }}
                    </button>

                    @if ($editingId)
                        <button wire:click="$set('editingId', null)" type="button"
                                class="text-sm text-gray-500 hover:underline">
                            Cancel
                        </button>
                    @endif

                    @if ($confirmingReset)
                        <span class="text-sm text-gray-600 dark:text-gray-300 flex items-center gap-2">
                            Confirm reset?
                            <button wire:click="resetForm" class="text-blue-600 hover:underline">Yes</button>
                            <button wire:click="$set('confirmingReset', false)" class="text-gray-500 hover:underline">No</button>
                        </span>
                    @else
                        <button wire:click="confirmReset" type="button" class="text-sm text-red-500 hover:underline">
                            Reset All
                        </button>
                    @endif
                </div>
            </div>
        </form>

        <!-- Recherche -->
        <div class="pt-6">
            <x-forms.input 
                wire:model.debounce.300ms="search" 
                placeholder="🔍 Search transporter..." 
                class="w-full rounded-lg border-gray-300 dark:border-gray-600" 
            />
        </div>

        <!-- Tableau -->
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
                                <button wire:click="edit({{ $transporter->id }})"
                                        class="text-indigo-600 text-xs font-medium hover:underline">Edit</button>

                                @if ($confirmingDelete === $transporter->id)
                                    <span class="text-sm text-gray-600 dark:text-gray-300">
                                        Confirm?
                                        <button wire:click="delete({{ $transporter->id }})"
                                                class="text-red-600 ml-1 hover:underline">Yes</button>
                                        <button wire:click="$set('confirmingDelete', null)"
                                                class="text-gray-500 ml-1 hover:underline">No</button>
                                    </span>
                                @else
                                    <button wire:click="confirmDelete({{ $transporter->id }})"
                                            class="text-red-600 text-xs font-medium hover:underline">Delete</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">No transporters found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-4">
            {{ $transporters->links() }}
        </div>
    </div>
</div>
