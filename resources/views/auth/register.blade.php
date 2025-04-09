<x-guest-layout>
    <div class="relative p-6 bg-white z-1 dark:bg-gray-900 sm:p-0">
      <div class="relative flex flex-col justify-center w-full h-screen dark:bg-gray-900 sm:p-0 lg:flex-row">
        <!-- Form Section -->
        <div class="flex flex-col flex-1 w-full lg:w-1/2">
          <div class="w-full max-w-md pt-10 mx-auto">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
              <svg class="stroke-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              Back to dashboard
            </a>
          </div>
  
          <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto">
            <div>
              <div class="mb-5 sm:mb-8">
                <h1 class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md">
                  {{ __('Register') }}
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                  {{ __('Create your account to get started') }}
                </p>
              </div>
  
              <!-- Validation Errors -->
              @if ($errors->any())
                <div class="mb-4 text-sm text-red-600 bg-red-100 border border-red-200 rounded-lg px-4 py-3 dark:bg-red-950 dark:text-red-400 dark:border-red-700">
                  <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
  
              <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="space-y-5">
                  <!-- Name -->
                  <div>
                    <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                      {{ __('Name') }}<span class="text-error-500">*</span>
                    </label>
                    <x-text-input id="name" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                  </div>
  
                  <!-- Email -->
                  <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                      {{ __('Email') }}<span class="text-error-500">*</span>
                    </label>
                    <x-text-input id="email" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                  </div>
  
                  <!-- Password -->
                  <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                      {{ __('Password') }}<span class="text-error-500">*</span>
                    </label>
                    <x-text-input id="password" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                  </div>
  
                  <!-- Confirm Password -->
                  <div>
                    <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                      {{ __('Confirm Password') }}<span class="text-error-500">*</span>
                    </label>
                    <x-text-input id="password_confirmation" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                  </div>
  
                  <!-- Submit -->
                  <div class="flex items-center justify-between">
                    <a class="text-sm text-brand-500 hover:text-brand-600 dark:text-brand-400" href="{{ route('login') }}">
                      {{ __('Already registered?') }}
                    </a>
                    <x-primary-button class="ms-4 px-6 py-3 text-sm font-medium rounded-lg">
                      {{ __('Register') }}
                    </x-primary-button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
  
        <!-- Side Content -->
        <div class="relative items-center hidden w-full h-full bg-brand-950 dark:bg-white/5 lg:grid lg:w-1/2">
          <div class="flex items-center justify-center z-1">
            <div class="flex flex-col items-center max-w-xs">
              <a href="{{ route('login') }}" class="block mb-4">
                <img src="{{ asset('images/logo/auth-logo.svg') }}" alt="Logo" />
              </a>
              <p class="text-center text-gray-400 dark:text-white/60">
                {{ __('Join the best platform for modern app developers.') }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </x-guest-layout>
  