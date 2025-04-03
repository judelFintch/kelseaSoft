<div>
    <body
      x-data="{ page: 'dashboard', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
      x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
      $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
      :class="{ 'dark bg-gray-900': darkMode === true }"
    >
      <!-- ===== Preloader Start ===== -->
      <div
        x-show="loaded"
        x-init="window.addEventListener('DOMContentLoaded', () => { setTimeout(() => loaded = false, 500) })"
        class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black"
      >
        <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent"></div>
      </div>
      <!-- ===== Preloader End ===== -->
  
      <!-- ===== Page Wrapper Start ===== -->
      <div class="flex h-screen overflow-hidden">
        @livewire('partials.aside.asidebar')
  
        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
          <!-- Small Device Overlay Start -->
          <div
            @click="sidebarToggle = false"
            :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
            class="fixed w-full h-screen z-9 bg-gray-900/50"
          ></div>
          <!-- Small Device Overlay End -->
  
          <!-- ===== Header Start ===== -->
          @livewire('partials.header.header')
          <!-- ===== Header End ===== -->
  
          <!-- ===== Main Content Start ===== -->
          <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
              <div class="grid grid-cols-12 gap-4 md:gap-6">
                <div class="col-span-12 space-y-6 xl:col-span-7">
                  @livewire('partials.cards.section-card')
                </div>
  
                <div class="col-span-12 xl:col-span-5">
                  <!-- ====== Chart Two Start -->
                  @livewire('partials.chart.chart-two')
                  <!-- ====== Chart Two End -->
                </div>
  
                <div class="col-span-12">
                  <!-- ====== Chart Three Start -->
                  @livewire('partials.chart.chart-three-start')
                  <!-- ====== Chart Three End -->
                </div>
  
                <div class="col-span-12 xl:col-span-12">
                  @livewire('partials.recents.declarations')
                </div>
              </div>
            </div>
          </main>
          <!-- ===== Main Content End ===== -->
        </div>
        <!-- ===== Content Area End ===== -->
      </div>
      <!-- ===== Page Wrapper End ===== -->
    </body>
  </div>