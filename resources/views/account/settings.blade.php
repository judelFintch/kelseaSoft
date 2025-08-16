<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Account Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="post" action="{{ route('account.settings.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="notifications_enabled" :value="__('Email Notifications')" />
                            <input id="notifications_enabled" name="notifications_enabled" type="checkbox" value="1" class="mt-1" {{ old('notifications_enabled', $user->notifications_enabled) ? 'checked' : '' }} />
                            <x-input-error class="mt-2" :messages="$errors->get('notifications_enabled')" />
                        </div>

                        <div>
                            <x-input-label for="language" :value="__('Language')" />
                            <select id="language" name="language" class="mt-1 block w-full">
                                <option value="en" {{ old('language', $user->language) == 'en' ? 'selected' : '' }}>English</option>
                                <option value="fr" {{ old('language', $user->language) == 'fr' ? 'selected' : '' }}>Français</option>
                                <option value="es" {{ old('language', $user->language) == 'es' ? 'selected' : '' }}>Español</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('language')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>

                            @if (session('status') === 'settings-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
