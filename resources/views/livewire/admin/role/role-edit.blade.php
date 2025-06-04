<div>
    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <div>
                <h2 class="text-2xl font-semibold leading-tight">Edit Role: {{ $display_name ?? $name }}</h2>
            </div>
             @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-3" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <form wire:submit.prevent="updateRole" class="mt-6">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Name (Code - e.g., 'admin', 'editor')
                        </label>
                        <input wire:model.defer="name" type="text" placeholder="Role Name (Code)" id="name"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                               {{ $role->name === 'root' ? 'disabled' : '' }}>
                        @error('name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        @if($role->name === 'root')
                        <p class="text-xs text-gray-600 mt-1">The 'root' role name cannot be changed.</p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="display_name">
                            Display Name (Optional - e.g., 'Administrator', 'Content Editor')
                        </label>
                        <input wire:model.defer="display_name" type="text" placeholder="Display Name" id="display_name"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('display_name') border-red-500 @enderror">
                        @error('display_name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                            Description (Optional)
                        </label>
                        <textarea wire:model.defer="description" placeholder="Description" id="description"
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror"></textarea>
                        @error('description') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="permissions">
                            Assign Permissions
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($permissions as $permission)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" wire:model.defer="selectedPermissions" value="{{ $permission->id }}"
                                           class="form-checkbox h-5 w-5 text-blue-600"
                                           {{ $role->name === 'root' ? 'disabled' : '' }}>
                                    <span class="text-gray-700">{{ $permission->display_name ?? $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('selectedPermissions') <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p> @enderror
                         @if($role->name === 'root')
                        <p class="text-xs text-gray-600 mt-1">Permissions for the 'root' role cannot be changed.</p>
                        @endif
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Update Role
                        </button>
                        <a href="{{ route('admin.role.index') }}"
                           class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
