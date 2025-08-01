<div>
    <div class="max-w-7xl mx-auto px-4 py-6">
        {{-- Column Selection UI --}}
        <div class="mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
            <h4 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-200">Select Visible Columns:</h4>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">
                @foreach($allColumns as $key => $label)
                    <label class="flex items-center space-x-2 p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                        <input type="checkbox" wire:model.live="visibleColumns" value="{{ $key }}" class="form-checkbox h-5 w-5 text-indigo-600 rounded dark:bg-gray-800 dark:border-gray-600 focus:ring-indigo-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="overflow-x-auto border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-white sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th> {{-- Static first column --}}
                        @foreach($allColumns as $key => $label)
                            @if(in_array($key, $visibleColumns))
                                <th class="px-4 py-3 text-left">{{ $label }}</th>
                            @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($folders as $folder)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td> {{-- Static first cell --}}
                            @foreach($allColumns as $key => $label)
                                @if(in_array($key, $visibleColumns))
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @switch($key)
                                            @case('folder_number')
                                                <a href="{{ route('folder.show', $folder->id) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-600 font-medium">
                                                    {{ $folder->folder_number }}
                                                </a>
                                                @break
                                            @case('transporter_name')
                                                {{ $folder->transporter?->name }}
                                                @break
                                            @case('origin_name')
                                                {{ $folder->origin?->name }}
                                                @break
                                            @case('destination_name')
                                                {{ $folder->destination?->name }}
                                                @break
                                            @case('supplier_name')
                                                {{ $folder->supplier?->name }}
                                                @break
                                            @case('company_name')
                                                {{ $folder->company?->name }}
                                                @break
                                            @case('customs_office_name')
                                                {{ $folder->customsOffice?->name }}
                                                @break
                                            @case('declaration_type_name')
                                                {{ $folder->declarationType?->name }}
                                                @break
                                            @case('license_number')
                                                {{ $folder->license?->license_number }}
                                                @break
                                            @case('folder_date')
                                            @case('arrival_border_date')
                                            @case('tr8_date')
                                            @case('t1_date')
                                            @case('im4_date')
                                            @case('liquidation_date')
                                            @case('quitance_date')
                                                {{ optional($folder->$key)->format('Y-m-d') }}
                                                @break
                                            @case('description')
                                                {{ Str::limit($folder->description, 25) }}
                                                @break
                                            @default
                                                {{ $folder->$key }}
                                        @endswitch
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            {{-- Adjust colspan: 1 for # column + count of visible columns --}}
                            <td colspan="{{ 1 + count($visibleColumns) }}" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">No folders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
