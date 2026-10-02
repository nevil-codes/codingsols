<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-gray-200/80 dark:border-gray-800/80 bg-white/80 dark:bg-gray-950/80 backdrop-blur">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-14 gap-4">
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold tracking-tight">
                    <x-application-logo class="h-7 w-7" />
                    <span>codingsols</span>
                </a>

                <div class="hidden md:flex items-center gap-6">
                    <x-nav-link :href="route('home').'#categories'" :active="request()->routeIs('categories.*')">Categories</x-nav-link>
                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">About</x-nav-link>
                    <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">Contact</x-nav-link>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-3">
                <form action="{{ route('search') }}" method="GET" role="search">
                    <label for="nav-search" class="sr-only">Search questions</label>
                    <div class="relative">
                        <svg class="pointer-events-none absolute left-2.5 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.45 4.39l3.08 3.08a.75.75 0 1 1-1.06 1.06l-3.08-3.08A7 7 0 0 1 2 9Z" clip-rule="evenodd" /></svg>
                        <input id="nav-search" type="search" name="q" value="{{ request()->routeIs('search') ? request('q') : '' }}" placeholder="Search…"
                            class="w-48 lg:w-64 rounded-lg border-gray-200 bg-gray-50 pl-8 py-1.5 text-sm focus:bg-white focus:border-accent-500 focus:ring-accent-500 dark:border-gray-800 dark:bg-gray-900 dark:focus:bg-gray-900">
                    </div>
                </form>

                <div x-data="themeToggle"><x-theme-toggle /></div>

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center rounded-full focus:outline-none focus-visible:ring-2 focus-visible:ring-accent-500 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-gray-950" aria-label="Account menu">
                                <x-avatar :user="Auth::user()" size="sm" />
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                                <div class="text-sm font-medium truncate">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</div>
                            </div>
                            <x-dropdown-link :href="route('dashboard')">My activity</x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Log in</a>
                    <x-button :href="route('register')" size="sm">Sign up</x-button>
                @endauth
            </div>

            <div class="flex items-center gap-1 md:hidden">
                <div x-data="themeToggle"><x-theme-toggle /></div>
                <button @click="open = ! open" class="p-2 rounded-md text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800" :aria-expanded="open.toString()" aria-controls="mobile-menu" aria-label="Toggle menu">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" x-cloak x-show="open" class="md:hidden border-t border-gray-200 dark:border-gray-800">
        <div class="px-4 py-3">
            <form action="{{ route('search') }}" method="GET" role="search">
                <label for="mobile-search" class="sr-only">Search questions</label>
                <input id="mobile-search" type="search" name="q" placeholder="Search questions…"
                    class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 text-sm focus:border-accent-500 focus:ring-accent-500 dark:border-gray-800 dark:bg-gray-900">
            </form>
        </div>
        <div class="pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home').'#categories'" :active="request()->routeIs('categories.*')">Categories</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">About</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">Contact</x-responsive-nav-link>
        </div>
        <div class="pt-3 pb-4 border-t border-gray-200 dark:border-gray-800">
            @auth
                <div class="px-4 flex items-center gap-3">
                    <x-avatar :user="Auth::user()" />
                    <div>
                        <div class="font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('dashboard')">My activity</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log out</x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4 flex gap-3">
                    <x-button :href="route('login')" variant="secondary" class="flex-1">Log in</x-button>
                    <x-button :href="route('register')" class="flex-1">Sign up</x-button>
                </div>
            @endauth
        </div>
    </div>
</nav>
