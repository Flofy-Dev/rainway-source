<html>
<head>
@yield('title')
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo-nav class="rainway" />
                    </a>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Home') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('games')" :active="request()->routeIs('games')">
                        {{ __('Games') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('users')" :active="request()->routeIs('users')">
                        {{ __('Users') }}
                    </x-nav-link>
                </div>
                
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="/forum" :active="Request::is('forum*')">
                        {{ __('Forum') }}
                    </x-nav-link>
                </div>
                
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('download')" :active="request()->routeIs('download')">
                        {{ __('Download') }}
                    </x-nav-link>
                </div>
                
                @if ( Auth::user()->admin == 1 )
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('adminpanel')" :active="request()->routeIs('adminpanel')">
                            {{ __('Admin Panel') }}
                        </x-nav-link>
                    </div>
                @endif
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div style="position: relative; right: 20px;">
                    <x-moneyicon></x-moneyicon>
                </div>
                <div style="position: relative; right: 16px;">
                    <a>{{ Auth::user()->rainbux }}</a>
                </div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('settings')">
                            {{ __('Settings') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                        
                        <!-- Discord Link -->
                        <x-dropdown-link href="https://discord.gg/B7KsMcEY4A">
                            {{ __('Discord') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>

            

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Home') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('games')" :active="request()->routeIs('games')">
                {{ __('Games') }}
            </x-responsive-nav-link>
        </div>
        
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('users')" :active="request()->routeIs('users')">
                {{ __('Users') }}
            </x-responsive-nav-link>
        </div>
        
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="/forum" :active="Request::is('forum*')">
                {{ __('Forum') }}
            </x-responsive-nav-link>
        </div>
        
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('download')" :active="request()->routeIs('download')">
                {{ __('Download') }}
            </x-responsive-nav-link>
        </div>
        
        @if ( Auth::user()->admin == 1 )
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('adminpanel')" :active="request()->routeIs('adminpanel')">
                    {{ __('Admin Panel') }}
                </x-responsive-nav-link>
            </div>
        @endif
        
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('settings')">
                    {{ __('Settings') }}
                </x-responsive-nav-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
                
                <!-- Discord Link -->
                <x-responsive-nav-link href="https://discord.gg/B7KsMcEY4A">
                    {{ __('Discord') }}
                </x-responsive-nav-link>
            </div>
        </div>
    </div>
</nav>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 py-0 py-md-0">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
            <div class="flex-shrink-0 flex items-center">
                    <x-nav-link :href="route('shop')" :active="request()->routeIs('shop')">
                        Shop
                    </x-nav-link>
                </div>
                <div class="flex-shrink-0 flex items-center">
                    <x-nav-link style="position:relative; left:7px;" :href="route('avatar')" :active="request()->routeIs('avatar')">
                        Avatar
                    </x-nav-link>
                </div>
                <div class="flex-shrink-0 flex items-center">
                    <x-nav-link style="position:relative; left:14px;" href="/public/profile?id={{ Auth::user()->id }}" :active="request()->routeIs('profile')">
                        Profile
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>

</head>
</html>