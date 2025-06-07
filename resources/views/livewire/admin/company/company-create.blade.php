<div>
    <x-ui.flash-message />
    <x-ui.error-message />
    <div class="max-w-5xl mx-auto p-6">
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
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Company Information</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Name -->
                            <x-forms.input label="Name" model="name" placeholder="Enter company name" />
                            <!-- Acronym -->
                            <x-forms.input label="Acronym" model="acronym" placeholder="Enter company acronym" />
                            <!-- Business Category -->
                            <x-forms.input label="Business Category" model="business_category" placeholder="Enter business category" />
                            <!-- Tax ID -->
                            <x-forms.input label="Tax ID" model="tax_id" placeholder="Enter tax ID" />
                            <!-- Code -->
                            <x-forms.input label="Code" model="code" placeholder="Enter company code" />
                            <!-- National Identification -->
                            <x-forms.input label="National ID" model="national_identification" placeholder="Enter national ID" />
                            <!-- Commercial Register -->
                            <x-forms.input label="Commercial Register" model="commercial_register" placeholder="Enter register number" />
                            <!-- Import/Export Number -->
                            <x-forms.input label="Import/Export Number" model="import_export_number" placeholder="Enter import/export number" />
                            <!-- NBC Number -->
                            <x-forms.input label="NBC Number" model="nbc_number" placeholder="Enter NBC number" />
                        </div>
                    </div>

                    <!-- Section 2: Contact Information -->
                    <div class="pt-5">
                        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Contact Information</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Phone Number -->
                            <x-forms.input label="Phone Number" model="phone_number" placeholder="+243 999..." />
                            <!-- Email -->
                            <x-forms.input label="Email" model="email" type="email" placeholder="example@mail.com" />
                            <!-- Address -->
                            <x-forms.input label="Physical Address" model="physical_address" placeholder="Company address" class="sm:col-span-2" />
                        </div>
                    </div>
                </div>

                <!-- ✅ Updated Button -->
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-white transition-all duration-200 bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 rounded-xl shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                        Save Company
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
