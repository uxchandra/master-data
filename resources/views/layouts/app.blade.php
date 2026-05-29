<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Master Data') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .sidebar-collapsed { width: 5rem; }
        .sidebar-expanded { width: 16rem; }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: true }">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'sidebar-expanded' : 'sidebar-collapsed'"
               class="bg-gradient-to-b from-[#364e4c] to-[#2d403e] text-white border-r border-[#2d403e] hidden lg:block transition-all duration-300 ease-in-out relative shrink-0">
            <div class="h-full flex flex-col">

                <!-- Header: Logo & Toggle -->
                <div class="flex items-center h-16 px-4 border-b border-white/10">
                    <a href="{{ route('dashboard') }}"
                       x-show="sidebarOpen"
                       x-transition:enter="transition ease-out duration-100"
                       x-transition:enter-start="opacity-0"
                       x-transition:enter-end="opacity-100"
                       class="text-lg font-bold text-white hover:text-emerald-200 transition flex items-center space-x-2 flex-1 min-w-0">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto shrink-0"
                             onerror="this.style.display='none';">
                        <span class="truncate">{{ config('app.name', 'Master Data') }}</span>
                    </a>

                    <!-- Icon saat collapsed -->
                    <div x-show="!sidebarOpen" class="mx-auto">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7z"></path>
                        </svg>
                    </div>

                    <!-- Toggle Button -->
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="p-2 rounded-lg text-white/70 hover:text-white hover:bg-white/10 transition shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
                    <a href="{{ route('dashboard') }}"
                       :title="!sidebarOpen ? 'Dashboard' : ''"
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-white/15 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="truncate">Dashboard</span>
                    </a>

                    <!-- Materials Accordion -->
                    <div x-data="{ open: {{ request()->routeIs('materials.*') ? 'true' : 'false' }} }">

                        {{-- Header tombol accordion (hanya muncul saat sidebar expanded) --}}
                        <button x-show="sidebarOpen"
                                @click="open = !open"
                                class="w-full flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition mt-1
                                       {{ request()->routeIs('materials.*') ? 'bg-white/15 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="flex-1 text-left truncate">Materials</span>
                            <svg class="w-4 h-4 shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        {{-- Icon saat sidebar collapsed: langsung link ke suppliers --}}
                        <a x-show="!sidebarOpen"
                           href="{{ route('materials.suppliers.index') }}"
                           title="Materials"
                           class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition mt-1
                                  {{ request()->routeIs('materials.*') ? 'bg-white/15 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </a>

                        {{-- Sub-menu dropdown --}}
                        <div x-show="open && sidebarOpen"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="mt-1 ml-4 pl-4 border-l border-white/20 space-y-1">
                             
                            <a href="{{ route('materials.items.index') }}"
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition
                                      {{ request()->routeIs('materials.items.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-4 h-4 mr-2.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Items
                            </a>

                            <a href="{{ route('materials.suppliers.index') }}"
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition
                                      {{ request()->routeIs('materials.suppliers.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-4 h-4 mr-2.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Supplier
                            </a>
                        </div>
                    </div>

                    <!-- Manajemen User Accordion -->
                    <div x-data="{ open: {{ request()->routeIs('user-management.*') ? 'true' : 'false' }} }">

                        <button x-show="sidebarOpen"
                                @click="open = !open"
                                class="w-full flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition mt-1
                                       {{ request()->routeIs('user-management.*') ? 'bg-white/15 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="flex-1 text-left truncate">Manajemen User</span>
                            <svg class="w-4 h-4 shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <a x-show="!sidebarOpen"
                           href="{{ route('user-management.users.index') }}"
                           title="Manajemen User"
                           class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition mt-1
                                  {{ request()->routeIs('user-management.*') ? 'bg-white/15 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </a>

                        <div x-show="open && sidebarOpen"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="mt-1 ml-4 pl-4 border-l border-white/20 space-y-1">

                            <a href="{{ route('user-management.users.index') }}"
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition
                                      {{ request()->routeIs('user-management.users.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-4 h-4 mr-2.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Users
                            </a>

                            <a href="{{ route('user-management.roles.index') }}"
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition
                                      {{ request()->routeIs('user-management.roles.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-4 h-4 mr-2.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Roles
                            </a>

                            <a href="{{ route('user-management.permissions.index') }}"
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition
                                      {{ request()->routeIs('user-management.permissions.*') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-4 h-4 mr-2.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                                Permissions
                            </a>
                        </div>
                    </div>

                    @isset($navigation)
                        {{ $navigation }}
                    @endisset
                </nav>

                <!-- User info di bottom sidebar -->
                <div x-show="sidebarOpen" class="px-4 py-4 border-t border-white/10">
                    <div class="flex items-center space-x-3">
                        <div class="h-8 w-8 rounded-full bg-white/20 text-white flex items-center justify-center font-semibold text-sm shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-white/60 truncate">{{ Auth::user()->username }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col bg-slate-50 min-w-0 overflow-hidden">

            <!-- Top Bar (mobile + desktop) -->
            <nav class="bg-white border-b border-slate-200 shadow-sm">
                <div class="mx-auto px-4">
                    <div class="flex justify-between h-16" x-data="{ open: false }">
                        <div class="flex items-center">
                            <!-- Logo mobile -->
                            <div class="lg:hidden">
                                <a href="{{ route('dashboard') }}" class="text-lg font-bold text-primary flex items-center space-x-2">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto"
                                         onerror="this.style.display='none';">
                                    <span>{{ config('app.name', 'Master Data') }}</span>
                                </a>
                            </div>

                            <!-- Page title / breadcrumb area -->
                            <div class="hidden lg:block">
                                @isset($header)
                                    {{ $header }}
                                @endisset
                            </div>
                        </div>

                        <!-- User Dropdown (Desktop) -->
                        <div class="hidden sm:flex sm:items-center">
                            <div x-data="{ open: false }" @click.away="open = false" class="relative">
                                <button @click="open = !open"
                                        class="flex items-center space-x-3 px-3 py-2 text-sm font-medium text-slate-700 hover:text-primary hover:bg-slate-50 rounded-lg focus:outline-none transition">
                                    <div class="h-9 w-9 rounded-full bg-primary text-white flex items-center justify-center font-semibold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <div class="text-left">
                                        <div class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-slate-500">{{ Auth::user()->username }}</div>
                                    </div>
                                    <svg class="h-4 w-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-show="open"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-52 rounded-lg shadow-xl origin-top-right bg-white ring-1 ring-black/5 overflow-hidden z-50"
                                     style="display: none;">
                                    <div class="px-4 py-3 border-b border-slate-100">
                                        <div class="text-sm font-medium text-slate-900">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-slate-500">{{ Auth::user()->username }}</div>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition">
                                        <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Profile
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition border-t border-slate-100">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Hamburger (Mobile) -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-600 hover:text-slate-800 hover:bg-slate-100 transition">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden" x-data="{ open: false }">
                    <div class="pt-2 pb-3 space-y-1">
                        <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('dashboard') ? 'border-primary text-primary bg-primary/5' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300' }} text-base font-medium transition">
                            Dashboard
                        </a>
                    </div>
                    <div class="pt-4 pb-1 border-t border-slate-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-slate-500">{{ Auth::user()->username }}</div>
                        </div>
                        <div class="mt-3 space-y-1">
                            <a href="{{ route('profile.edit') }}" class="flex items-center pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-600 hover:bg-slate-50 transition">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-red-600 hover:bg-red-50 transition">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading (mobile) -->
            @isset($header)
                <header class="bg-white shadow-sm border-b border-slate-200 lg:hidden">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                <div class="py-6">
                    @if(session('success'))
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg shadow-sm flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg shadow-sm flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
