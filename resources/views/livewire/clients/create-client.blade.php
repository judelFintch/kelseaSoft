<div>
  <main>
      <div class="mx-auto max-w-screen-2xl p-4 md:p-6">
          <!-- Breadcrumb Start -->
          <div x-data="{ pageName: `Create Client` }">
              <include src="./partials/breadcrumb.html" />
          </div>
          <!-- Breadcrumb End -->

          <div class="min-h-screen rounded-2xl border border-gray-200 bg-white px-5 py-7 dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-12">
              <main>
                  <div class="mx-auto max-w-screen-lg p-4 md:p-6">
                      <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Create New Client</h2>
                      <form wire:submit.prevent="submit" class="mt-6 grid grid-cols-2 gap-6">
                          <!-- Left Side -->
                          <div class="space-y-6">
                              <div>
                                  <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                      Company Name
                                  </label>
                                  <input type="text" wire:model="company_name" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white" required />
                                  @error('company_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                              </div>
                              <div>
                                  <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                      Contact Person
                                  </label>
                                  <input type="text" wire:model="contact_person" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                              </div>
                              <div>
                                  <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                      Email
                                  </label>
                                  <input type="email" wire:model="email" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white" required />
                                  @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                              </div>
                              <div>
                                  <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                      Phone
                                  </label>
                                  <input type="text" wire:model="phone" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                              </div>
                          </div>
                          <!-- Right Side -->
                          <div class="space-y-6">
                              <div>
                                  <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                      Secondary Phone
                                  </label>
                                  <input type="text" wire:model="secondary_phone" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                              </div>
                              <div>
                                  <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                      Address
                                  </label>
                                  <input type="text" wire:model="address" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                              </div>
                              <div>
                                  <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                      City
                                  </label>
                                  <input type="text" wire:model="city" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                              </div>
                          </div>
                          <div class="col-span-2 flex justify-end">
                              <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700">
                                  Save Client
                              </button>
                          </div>
                      </form>
                      @if (session()->has('success'))
                          <div class="mt-4 text-green-600 text-sm">
                              {{ session('success') }}
                          </div>
                      @endif
                  </div>
              </main>
          </div>
      </div>
  </main>
</div>
