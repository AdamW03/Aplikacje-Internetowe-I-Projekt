<nav x-data="{ open: false }" class="fixed top-0 w-full bg-white border-b border-gray-100 shadow z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('tournaments.index')" :active="request()->routeIs('tournaments.index')">
                        {{ __('Tournaments') }}
                    </x-nav-link>
                    <x-nav-link :href="route('games.index')" :active="request()->routeIs('games.index')">
                        {{ __('Games') }}
                    </x-nav-link>

                    <x-nav-link :href="route('game_tags.index')" :active="request()->routeIs('game_tags.index')">
                        {{ __('Game Tags') }}
                    </x-nav-link>

                    {{--                    @auth--}}
{{--                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">--}}
{{--                            {{ __('Dashboard') }}--}}
{{--                        </x-nav-link>--}}
{{--                    @endauth--}}
                    <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                        {{ __('About') }}
                    </x-nav-link>
                    @admin
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                            {{ __('Admin Panel') }}
                        </x-nav-link>
                    @endadmin
                    @guest
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                            {{ __('Log In') }}
                        </x-nav-link>
                        <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                            {{ __('Register') }}
                        </x-nav-link>
                    @endguest
                </div>
            </div>

{{--            Accesability settings--}}
            <div class="inline-flex justify-end space-x-4 p-4">
                <!-- Dropdown for Font Size -->
                <div class="flex justify-center items-center h-full">
                    <label for="fontSizeSelector" class="mr-4">Font Size</label>
                    <select id="fontSizeSelector" class="form-select rounded-md h-10">
                        <option value="small">Small</option>
                        <option value="normal">Normal</option>
                        <option value="large">Large</option>
                    </select>
                </div>

                <!-- Button for Contrast Toggle -->
                <button id="contrastButton" class="bg-gray-700 text-white rounded-md text-sm sm:text-base md:text-lg py-2 px-4 flex justify-center items-center min-w-[150px] h-auto whitespace-nowrap">
                    Toggle Contrast
                </button>
            </div>

            <!-- Settings Dropdown -->
            @auth
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <img src="{{ Auth::user()->avatars ? asset('storage/avatars/' . Auth::user()->avatars) : asset('images/avatar.png') }}" alt="User Avatar" class="block h-12 w-auto rounded-lg shadow-lg mx-auto mr-4">

                                <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
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
                    </x-slot>
                </x-dropdown>
            </div>
            @endauth

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
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
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
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
                </div>
            </div>
            @endauth
    </div>
</nav>
