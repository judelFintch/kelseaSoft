<div>
    <!-- ===== Sidebar Start ===== -->
    <aside :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
        class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0">
        <!-- SIDEBAR HEADER -->
        <div :class="sidebarToggle ? 'justify-center' : 'justify-between'"
            class="flex items-center gap-2 pt-8 sidebar-header pb-7">
            <a href="{{route('dashboard')}}">
                <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                    <img class="dark:hidden" src="{{ asset('src/images/logo/logo.png') }}" alt="Logo" />
                    <img class="hidden dark:block" src="{{ asset('src/images/logo/logo.png') }}" alt="Logo" />
                </span>
                <img class="logo-icon" :class="sidebarToggle ? 'lg:block' : 'hidden'"
                    src="{{ asset('src/images/logo/logo-icon.svg') }}" alt="Logo" />
            </a>
        </div>
        <!-- SIDEBAR HEADER -->

        <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
            <!-- Sidebar Menu -->
            <nav x-data="{ selected: $persist('Dashboard') }">
                <!-- Menu Group -->
                <div>
                    <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
                        <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
                            MENU
                        </span>

                        <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
                            class="mx-auto fill-current menu-group-icon" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 11.9951V11.9951Z"
                                fill="" />
                        </svg>
                    </h3>

                    <ul class="flex flex-col gap-4 mb-6">
                        <!-- Menu Item Dashboard -->
                        <li>
                            <a href="#" @click.prevent="selected = (selected === 'Dashboard' ? '':'Dashboard')"
                                class="menu-item group"
                                :class="(selected === 'Dashboard') || (page === 'ecommerce' || page === 'analytics' ||
                                    page === 'marketing' || page === 'crm' || page === 'stocks') ?
                                'menu-item-active' : 'menu-item-inactive'">
                                <svg :class="(selected === 'Dashboard') || (page === 'ecommerce' || page === 'analytics' ||
                                    page === 'marketing' || page === 'crm' || page === 'stocks') ?
                                'menu-item-icon-active' : 'menu-item-icon-inactive'"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H9C9.41421 4.75 9.75 5.08579 9.75 5.5V8.99998C9.75 9.41419 9.41421 9.74998 9 9.74998H5.5C5.08579 9.74998 4.75 9.41419 4.75 8.99998V5.5ZM5.5 12.75C4.25736 12.75 3.25 13.7574 3.25 15V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H9C10.2426 20.75 11.25 19.7427 11.25 18.5V15C11.25 13.7574 10.2426 12.75 9 12.75H5.5ZM4.75 15C4.75 14.5858 5.08579 14.25 5.5 14.25H9C9.41421 14.25 9.75 14.5858 9.75 15V18.5C9.75 18.9142 9.41421 19.25 9 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15ZM12.75 5.5C12.75 4.25736 13.7574 3.25 15 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.99998C20.75 10.2426 19.7426 11.25 18.5 11.25H15C13.7574 11.25 12.75 10.2426 12.75 8.99998V5.5ZM15 4.75C14.5858 4.75 14.25 5.08579 14.25 5.5V8.99998C14.25 9.41419 14.5858 9.74998 15 9.74998H18.5C18.9142 9.74998 19.25 9.41419 19.25 8.99998V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H15ZM15 12.75C13.7574 12.75 12.75 13.7574 12.75 15V18.5C12.75 19.7426 13.7574 20.75 15 20.75H18.5C19.7426 20.75 20.75 19.7427 20.75 18.5V15C20.75 13.7574 19.7426 12.75 18.5 12.75H15ZM14.25 15C14.25 14.5858 14.5858 14.25 15 14.25H18.5C18.9142 14.25 19.25 14.5858 19.25 15V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15C14.5858 19.25 14.25 18.9142 14.25 18.5V15Z"
                                        fill="" />
                                </svg>

                                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                    Dashboard
                                </span>

                                <svg class="menu-item-arrow"
                                    :class="[(selected === 'Dashboard') ? 'menu-item-arrow-active' :
                                        'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : ''
                                    ]"
                                    width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke=""
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>

                            <!-- Dropdown Menu Start -->
                            <div class="overflow-hidden transform translate"
                                :class="(selected === 'Dashboard') ? 'block' : 'hidden'">
                                <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                    class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                                    <li>
                                        <a href="index.html" class="menu-dropdown-item group"
                                            :class="page === 'ecommerce' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Profil
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Dropdown Menu End -->
                        </li>
                        <!-- Menu Item Dashboard -->


                        <li>
                            <a href="#" @click.prevent="selected = (selected === 'Dossier' ? '' : 'Dossier')"
                                class="menu-item group"
                                :class="(selected === 'Dossier') || (page === 'dossierListe' || page === 'dossierCreate') ?
                                'menu-item-active' : 'menu-item-inactive'">
                                <svg :class="(selected === 'Dossier') || (page === 'dossierListe' || page === 'dossierCreate') ?
                                'menu-item-icon-active' : 'menu-item-icon-inactive'"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <<path d="M3 7a1 1 0 011-1h5l2 2h8a1 1 0 011 1v8a1 1 0 01-1 1H4a1 1 0 01-1-1V7z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                </svg>

                                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                    Dossiers
                                </span>

                                <svg class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                                    :class="[(selected === 'Dossier') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive',
                                        sidebarToggle ? 'lg:hidden' : ''
                                    ]"
                                    width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke=""
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>

                            <!-- Dropdown Menu Start -->
                            <div class="overflow-hidden transform translate"
                                :class="(selected === 'Dossier') ? 'block' : 'hidden'">
                                <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                    class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                                    <li>
                                        <a href="/douane/dossiers" class="menu-dropdown-item group"
                                            :class="page === 'dossierListe' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Liste
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('folder.create')}}" class="menu-dropdown-item group"
                                            :class="page === 'dossierCreate' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Nouveau Dossier
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Dropdown Menu End -->
                        </li>


                        <li>
                            <a href="#" @click.prevent="selected = (selected === 'Client' ? '' : 'Client')"
                                class="menu-item group"
                                :class="(selected === 'Client') || (page === 'clientListe' || page === 'clientCreate') ?
                                'menu-item-active' : 'menu-item-inactive'">
                                <svg :class="(selected === 'Client') || (page === 'clientListe' || page === 'clientCreate') ?
                                'menu-item-icon-active' : 'menu-item-icon-inactive'"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H18.5001C19.7427 20.75 20.7501 19.7426 20.7501 18.5V5.5C20.7501 4.25736 19.7427 3.25 18.5001 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5001C18.9143 4.75 19.2501 5.08579 19.2501 5.5V18.5C19.2501 18.9142 18.9143 19.25 18.5001 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V5.5ZM6.25005 9.7143C6.25005 9.30008 6.58583 8.9643 7.00005 8.9643L17 8.96429C17.4143 8.96429 17.75 9.30008 17.75 9.71429C17.75 10.1285 17.4143 10.4643 17 10.4643L7.00005 10.4643C6.58583 10.4643 6.25005 10.1285 6.25005 9.7143ZM6.25005 14.2857C6.25005 13.8715 6.58583 13.5357 7.00005 13.5357H17C17.4143 13.5357 17.75 13.8715 17.75 14.2857C17.75 14.6999 17.4143 15.0357 17 15.0357H7.00005C6.58583 15.0357 6.25005 14.6999 6.25005 14.2857Z"
                                        fill="" />
                                </svg>

                                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                    Clients
                                </span>

                                <svg class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                                    :class="[(selected === 'Client') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive',
                                        sidebarToggle ? 'lg:hidden' : ''
                                    ]"
                                    width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke=""
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>

                            <!-- Dropdown Menu Start -->
                            <div class="overflow-hidden transform translate"
                                :class="(selected === 'Client') ? 'block' : 'hidden'">
                                <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                    class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                                    
                                    <li>
                                        <a href="{{route('company.list')}}" class="menu-dropdown-item group"
                                            :class="page === 'clientListe' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Liste des Clients
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('company.create')}}" class="menu-dropdown-item group"
                                            :class="page === 'clientCreate' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Nouveau Client
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Dropdown Menu End -->
                        </li>

                        <li>
                            <a href="#" @click.prevent="selected = (selected === 'Licences' ? '' : 'Licences')"
                                class="menu-item group"
                                :class="(selected === 'Licences') || (page === 'licencesListe' ||
                                    page === 'licencesCreate') ? 'menu-item-active' : 'menu-item-inactive'">
                                <svg :class="(selected === 'Licences') || (page === 'licencesListe' ||
                                    page === 'licencesCreate') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H18.5001C19.7427 20.75 20.7501 19.7426 20.7501 18.5V5.5C20.7501 4.25736 19.7427 3.25 18.5001 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5001C18.9143 4.75 19.2501 5.08579 19.2501 5.5V18.5C19.2501 18.9142 18.9143 19.25 18.5001 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V5.5ZM6.25005 9.7143C6.25005 9.30008 6.58583 8.9643 7.00005 8.9643L17 8.96429C17.4143 8.96429 17.75 9.30008 17.75 9.71429C17.75 10.1285 17.4143 10.4643 17 10.4643L7.00005 10.4643C6.58583 10.4643 6.25005 10.1285 6.25005 9.7143ZM6.25005 14.2857C6.25005 13.8715 6.58583 13.5357 7.00005 13.5357H17C17.4143 13.5357 17.75 13.8715 17.75 14.2857C17.75 14.6999 17.4143 15.0357 17 15.0357H7.00005C6.58583 15.0357 6.25005 14.6999 6.25005 14.2857Z"
                                        fill="" />
                                </svg>

                                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                    Licences
                                </span>

                                <svg class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                                    :class="[(selected === 'Licences') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive',
                                        sidebarToggle ? 'lg:hidden' : ''
                                    ]"
                                    width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke=""
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>

                            <!-- Dropdown Menu Start -->
                            <div class="overflow-hidden transform translate"
                                :class="(selected === 'Licences') ? 'block' : 'hidden'">
                                <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                    class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                                    <li>
                                        <a href="/licences" class="menu-dropdown-item group"
                                            :class="page === 'licencesListe' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Liste des Licences
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/licences/create" class="menu-dropdown-item group"
                                            :class="page === 'licencesCreate' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Nouvelle Licence
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Dropdown Menu End -->
                        </li>

                        <li>
                            <a href="#" @click.prevent="selected = (selected === 'BIVAC' ? '' : 'BIVAC')"
                                class="menu-item group"
                                :class="(selected === 'BIVAC') || (page === 'bivacListe' || page === 'bivacCreate') ?
                                'menu-item-active' : 'menu-item-inactive'">
                                <svg :class="(selected === 'BIVAC') || (page === 'bivacListe' || page === 'bivacCreate') ?
                                'menu-item-icon-active' : 'menu-item-icon-inactive'"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H18.5001C19.7427 20.75 20.7501 19.7426 20.7501 18.5V5.5C20.7501 4.25736 19.7427 3.25 18.5001 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5001C18.9143 4.75 19.2501 5.08579 19.2501 5.5V18.5C19.2501 18.9142 18.9143 19.25 18.5001 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V5.5ZM6.25005 9.7143C6.25005 9.30008 6.58583 8.9643 7.00005 8.9643L17 8.96429C17.4143 8.96429 17.75 9.30008 17.75 9.71429C17.75 10.1285 17.4143 10.4643 17 10.4643L7.00005 10.4643C6.58583 10.4643 6.25005 10.1285 6.25005 9.7143ZM6.25005 14.2857C6.25005 13.8715 6.58583 13.5357 7.00005 13.5357H17C17.4143 13.5357 17.75 13.8715 17.75 14.2857C17.75 14.6999 17.4143 15.0357 17 15.0357H7.00005C6.58583 15.0357 6.25005 14.6999 6.25005 14.2857Z"
                                        fill="" />
                                </svg>

                                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                    BIVAC
                                </span>

                                <svg class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                                    :class="[(selected === 'BIVAC') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive',
                                        sidebarToggle ? 'lg:hidden' : ''
                                    ]"
                                    width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke=""
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>

                            <!-- Dropdown Menu Start -->
                            <div class="overflow-hidden transform translate"
                                :class="(selected === 'BIVAC') ? 'block' : 'hidden'">
                                <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                    class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                                    <li>
                                        <a href="/bivac" class="menu-dropdown-item group"
                                            :class="page === 'bivacListe' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Liste BIVAC
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/bivac/create" class="menu-dropdown-item group"
                                            :class="page === 'bivacCreate' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Nouveau BIVAC
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Dropdown Menu End -->
                        </li>
                        <li>
                            <a href="#"
                                @click.prevent="selected = (selected === 'Declarations' ? '' : 'Declarations')"
                                class="menu-item group"
                                :class="(selected === 'Declarations') || (page === 'declarationListe' ||
                                    page === 'declarationCreate') ? 'menu-item-active' : 'menu-item-inactive'">
                                <svg :class="(selected === 'Declarations') || (page === 'declarationListe' ||
                                    page === 'declarationCreate') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H18.5001C19.7427 20.75 20.7501 19.7426 20.7501 18.5V5.5C20.7501 4.25736 19.7427 3.25 18.5001 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5001C18.9143 4.75 19.2501 5.08579 19.2501 5.5V18.5C19.2501 18.9142 18.9143 19.25 18.5001 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V5.5ZM6.25005 9.7143C6.25005 9.30008 6.58583 8.9643 7.00005 8.9643L17 8.96429C17.4143 8.96429 17.75 9.30008 17.75 9.71429C17.75 10.1285 17.4143 10.4643 17 10.4643L7.00005 10.4643C6.58583 10.4643 6.25005 10.1285 6.25005 9.7143ZM6.25005 14.2857C6.25005 13.8715 6.58583 13.5357 7.00005 13.5357H17C17.4143 13.5357 17.75 13.8715 17.75 14.2857C17.75 14.6999 17.4143 15.0357 17 15.0357H7.00005C6.58583 15.0357 6.25005 14.6999 6.25005 14.2857Z"
                                        fill="" />
                                </svg>

                                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                    Déclarations
                                </span>

                                <svg class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                                    :class="[(selected === 'Declarations') ? 'menu-item-arrow-active' :
                                        'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : ''
                                    ]"
                                    width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke=""
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>

                            <!-- Dropdown Menu Start -->
                            <div class="overflow-hidden transform translate"
                                :class="(selected === 'Declarations') ? 'block' : 'hidden'">
                                <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                    class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                                    <li>
                                        <a href="/declarations" class="menu-dropdown-item group"
                                            :class="page === 'declarationListe' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Liste des Déclarations
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/declarations/create" class="menu-dropdown-item group"
                                            :class="page === 'declarationCreate' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Nouvelle Déclaration
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Dropdown Menu End -->
                        </li>



                        <li>
                            <a href="#"
                                @click.prevent="selected = (selected === 'Parametres' ? '' : 'Parametres')"
                                class="menu-item group"
                                :class="(selected === 'Parametres') ||
                                (page === 'Applications' || page === 'Utilisateurs' || page === 'Roles' ||
                                    page === 'RegimesDouaniers' || page === 'Employes' || page === 'Entreprises' ||
                                    page === 'ModesDeTransport' || page === 'Tares' || page === 'Devises' ||
                                    page === 'MethodesDePaiement' || page === 'Pays' || page === 'Villes') ?
                                'menu-item-active' : 'menu-item-inactive'">
                                <!-- Icône Paramètres (engrenage) mise à jour -->
                                <svg :class="(selected === 'Parametres') ||
                                (page === 'Applications' || page === 'Utilisateurs' || page === 'Roles' ||
                                    page === 'RegimesDouaniers' || page === 'Employes' || page === 'Entreprises' ||
                                    page === 'ModesDeTransport' || page === 'Tares' || page === 'Devises' ||
                                    page === 'MethodesDePaiement' || page === 'Pays' || page === 'Villes') ?
                                'menu-item-icon-active' : 'menu-item-icon-inactive'"
                                    width="24" height="24" viewBox="0 0 20 20" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.983 3.262a.75.75 0 00-1.466 0l-.377 1.789a6.503 6.503 0 00-1.452.842l-1.671-.432a.75.75 0 00-.956.787l.03 1.706a6.48 6.48 0 00-.123 1.459H3.75a.75.75 0 000 1.5h1.054c.03.487.088.97.173 1.446l-.03 1.705a.75.75 0 00.956.788l1.67-.432c.45.275.946.5 1.452.842l.377 1.79a.75.75 0 001.466 0l.377-1.79a6.481 6.481 0 001.452-.842l1.67.432a.75.75 0 00.956-.788l-.03-1.705c.085-.476.143-.96.173-1.446h1.054a.75.75 0 000-1.5h-1.054a6.48 6.48 0 00-.173-1.459l.03-1.706a.75.75 0 00-.956-.787l-1.67.432c-.506-.342-1.002-.567-1.452-.842l-.377-1.789zM10 13a3 3 0 110-6 3 3 0 010 6z" />
                                </svg>

                                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                    Paramètres
                                </span>

                                <svg class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                                    :class="[(selected === 'Parametres') ? 'menu-item-arrow-active' :
                                        'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : ''
                                    ]"
                                    width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke=""
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>

                            <!-- Dropdown Menu Start -->
                            <div class="overflow-hidden transform translate"
                                :class="(selected === 'Parametres') ? 'block' : 'hidden'">
                                <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                    class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                                    <li>
                                        <a href="/applications" class="menu-dropdown-item group"
                                            :class="page === 'Applications' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Applications
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/utilisateurs" class="menu-dropdown-item group"
                                            :class="page === 'Utilisateurs' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Utilisateurs
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/roles" class="menu-dropdown-item group"
                                            :class="page === 'Roles' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Rôles
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/regimes-douaniers" class="menu-dropdown-item group"
                                            :class="page === 'RegimesDouaniers' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Régimes douaniers
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/employes" class="menu-dropdown-item group"
                                            :class="page === 'Employes' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Employés
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/entreprises" class="menu-dropdown-item group"
                                            :class="page === 'Entreprises' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Entreprises
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/modes-de-transport" class="menu-dropdown-item group"
                                            :class="page === 'ModesDeTransport' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Modes de transport
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/tares" class="menu-dropdown-item group"
                                            :class="page === 'Tares' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Tares
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/devises" class="menu-dropdown-item group"
                                            :class="page === 'Devises' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Devises
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/methodes-de-paiement" class="menu-dropdown-item group"
                                            :class="page === 'MethodesDePaiement' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Méthodes de paiement
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/pays" class="menu-dropdown-item group"
                                            :class="page === 'Pays' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Pays
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/villes" class="menu-dropdown-item group"
                                            :class="page === 'Villes' ? 'menu-dropdown-item-active' :
                                                'menu-dropdown-item-inactive'">
                                            Villes
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Dropdown Menu End -->
                        </li>
                    </ul>
                </div>
                <!-- Others Group -->
            </nav>
            <!-- Sidebar Menu -->
            <!-- Promo Box -->
        </div>
    </aside>
</div>
