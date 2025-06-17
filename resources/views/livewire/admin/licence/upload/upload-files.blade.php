@php use Illuminate\Support\Facades\Storage; @endphp
<div class="space-y-4">
    <div>
        @if (session()->has('success'))
            <div class="text-green-700 bg-green-100 p-2 rounded">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <form wire:submit.prevent="uploadFile" class="flex items-center space-x-2">
        <input type="file" wire:model="file" class="border p-1" />
        @error('file')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded">Uploader</button>
    </form>

    <ul class="space-y-2">
        @foreach ($licence->files as $file)
            <li class="flex items-center justify-between bg-gray-50 p-2 rounded">
                <a href="{{ Storage::url($file->path) }}" target="_blank" class="text-blue-600 underline">{{ $file->name }}</a>
                <button wire:click="deleteFile({{ $file->id }})" class="text-red-600">Supprimer</button>
            </li>
        @endforeach
    </ul>
</div>
