<div>
    <div class="max-w-5xl mx-auto p-6">

        <!-- Ouvrir le form ici pour englober tout le contenu -->
        <form wire:submit.prevent="submitForm()">
            <div class="rounded-2xl top-6 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <!-- Card Header -->
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                        Create Company
                    </h3>
                </div>
                <!-- Card Content -->
                <div class="divide-y divide-gray-100 p-5 sm:p-6 dark:divide-gray-800">
                    <!-- Section 1: Company Information -->
                    <div class="pb-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">
                            Company Information
                        </h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Name -->
                            <div>
                                <label for="name"
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Name
                                </label>
                                <input type="text" id="name" wire:model.defer="name"
                                    placeholder="Enter company name"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('name')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Business Category -->
                            <div>
                                <label for="business_category"
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Business Category
                                </label>
                                <input type="text" id="business_category" wire:model.defer="business_category"
                                    placeholder="Enter business category"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('business_category')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Tax ID -->
                            <div>
                                <label for="tax_id"
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Tax ID
                                </label>
                                <input type="text" id="tax_id" wire:model.defer="tax_id"
                                    placeholder="Enter tax ID"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('tax_id')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Code -->
                            <div>
                                <label for="code"
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Code
                                </label>
                                <input type="text" id="code" wire:model.defer="code"
                                    placeholder="Enter company code"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('code')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- National Identification -->
                            <div>
                                <label for="national_identification"
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    National Identification
                                </label>
                                <input type="text" id="national_identification"
                                    wire:model.defer="national_identification" placeholder="Enter national ID"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('national_identification')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Commercial Register -->
                            <div>
                                <label for="commercial_register"
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Commercial Register
                                </label>
                                <input type="text" id="commercial_register" wire:model.defer="commercial_register"
                                    placeholder="Enter commercial register number"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('commercial_register')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Import/Export Number -->
                            <div>
                                <label for="import_export_number"
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Import/Export Number
                                </label>
                                <input type="text" id="import_export_number" wire:model.defer="import_export_number"
                                    placeholder="Enter import/export number"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('import_export_number')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- NBC Number -->
                            <div>
                                <label for="nbc_number"
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    NBC Number
                                </label>
                                <input type="text" id="nbc_number" wire:model.defer="nbc_number"
                                    placeholder="Enter NBC number"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('nbc_number')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Contact Information -->
                    <div class="pt-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">
                            Contact Information
                        </h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Phone Number with Country Code -->
                            <div x-data="{ selectedCountry: 'US', countryCodes: { 'US': '+1', 'GB': '+44', 'CA': '+1', 'AU': '+61' } }">
                                <label for="phone_number"
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Phone Number
                                </label>
                                <div class="relative">
                                    <div class="absolute">
                                        <select x-model="selectedCountry"
                                            class="appearance-none rounded-l-lg border-r border-gray-200 bg-transparent px-3 py-3 text-sm text-gray-700 focus:border-indigo-300 focus:ring-indigo-500/10 dark:border-gray-800 dark:text-gray-400">
                                            <option value="US">US</option>
                                            <option value="GB">GB</option>
                                            <option value="CA">CA</option>
                                            <option value="AU">AU</option>
                                        </select>
                                    </div>
                                    <input type="tel" id="phone_number" placeholder="+1 (555) 000-0000"
                                        wire:model.defer="phone_number"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-3 pl-[90px] pr-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                </div>
                                @error('phone_number')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email with Icon -->
                            <div>
                                <label for="email"
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Email
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute top-1/2 left-0 -translate-y-1/2 border-r border-gray-200 px-3.5 py-3 text-gray-500 dark:border-gray-800 dark:text-gray-400">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.04175 7.06206V14.375C3.04175 14.6511 3.26561 14.875 3.54175 14.875H16.4584C16.7346 14.875 16.9584 14.6511 16.9584 14.375V7.06245L11.1443 11.1168C10.457 11.5961 9.54373 11.5961 8.85638 11.1168L3.04175 7.06206Z"
                                                fill="#667085" />
                                        </svg>
                                    </span>
                                    <input type="email" id="email" placeholder="info@gmail.com"
                                        wire:model.defer="email"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-[62px] text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                </div>
                                @error('email')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Physical Address -->
                            <div class="sm:col-span-2">
                                <label for="physical_address"
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Physical Address
                                </label>
                                <input type="text" id="physical_address" wire:model.defer="physical_address"
                                    placeholder="Enter physical address"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-indigo-300 focus:ring-indigo-500/10 dark:focus:border-indigo-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('physical_address')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                        Save Company
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
