<x-guest-layout>
    <div class="relative p-6 bg-white z-1 dark:bg-gray-900 sm:p-0">
      <div class="relative flex flex-col justify-center w-full h-screen dark:bg-gray-900 sm:p-0 lg:flex-row">
        <!-- Form Section -->
        <div class="flex flex-col flex-1 w-full lg:w-1/2">
    
          <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto">
            <div>
              <div class="mb-5 sm:mb-8">
                <h1 class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md">
                  {{ __('Log in') }}
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                  {{ __('Enter your credentials to log in') }}
                </p>
              </div>
  
              <!-- Session Status -->
              <x-auth-session-status class="mb-4" :status="session('status')" />
  
              <!-- Global Validation Errors -->
              @if ($errors->any())
                <div class="mb-4 text-sm text-red-600 bg-red-100 border border-red-200 rounded-lg px-4 py-3 dark:bg-red-950 dark:text-red-400 dark:border-red-700">
                  <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
  
              <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="space-y-5">
                  <!-- Email Address -->
                  <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                      {{ __('Email') }}<span class="text-error-500">*</span>
                    </label>
                    <x-text-input id="email" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                  </div>
  
                  <!-- Password -->
                  <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                      {{ __('Password') }}<span class="text-error-500">*</span>
                    </label>
                    <x-text-input id="password" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                  </div>
  
                  <!-- Remember Me and Forgot Password -->
                  <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center text-sm font-normal text-gray-700 cursor-pointer select-none dark:text-gray-400">
                      <input id="remember_me" type="checkbox" class="sr-only peer" name="remember">
                      <div class="mr-3 h-5 w-5 flex items-center justify-center rounded-md border border-gray-300 dark:border-gray-700 peer-checked:bg-brand-500 peer-checked:border-brand-500">
                        <svg class="hidden peer-checked:block" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7" stroke="white" stroke-width="1.94437" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                      </div>
                      {{ __('Remember me') }}
                    </label>
  
                    @if (Route::has('password.request'))
                      <a class="text-sm text-brand-500 hover:text-brand-600 dark:text-brand-400" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                      </a>
                    @endif
                  </div>
  
                  <!-- Submit -->
                  <div>
                    <x-primary-button class="w-full justify-center px-4 py-3 text-sm font-medium rounded-lg bg-brand-500 hover:bg-brand-600 dark:bg-brand-400 dark:hover:bg-brand-500 login-button">
                      {{ __('Log in') }}
                    </x-primary-button>
                  </div>
                </div>
              </form>
  
              <!-- Sign Up Link -->
              
            </div>
          </div>
        </div>
  
        <!-- Optional image/side info -->
        <div class="relative items-center hidden w-full h-full bg-brand-950 dark:bg-white/5 lg:grid lg:w-1/2">
            <div class="flex items-center justify-center z-1">
              <div class="flex flex-col items-center max-w-xs">
                <a href="{{ route('login') }}" class="block mb-4">
                  <img src="{{ asset('images/logo/logo.png') }}" alt="Logo" />
                </a>
                <p class="text-center text-gray-400 dark:text-white/60">
                  {{ __('KelseaSoft – Software for Simplifying Customs Management Activities') }}
                </p>
              </div>
            </div>
          </div>
          
      </div>
    </div>
  </x-guest-layout>
  