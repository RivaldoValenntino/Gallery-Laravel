<div>
    <nav x-data="{ scrolled: false }" x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })" :class="{ 'border-b shadow-lg  dark:border-0': scrolled }"
        class="bg-white border-gray-200 dark:bg-gray-900 fixed top-0 w-full z-[999]">
        <div class="flex flex-wrap items-center justify-between max-w-full p-5 mx-auto">
            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('logo/logo-apps.svg') }}" alt="Logo" />
            </a>
            <div class="flex items-center space-x-3 md:order-2 md:space-x-0 rtl:space-x-reverse">
                <button type="button"
                    class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                    id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                    data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    @auth
                        @if (Auth::user()->avatar)
                            <img class="w-8 h-8 rounded-full" src="{{ asset(Auth::user()->avatar) }}"
                                alt="{{ Auth::user()->name }}">
                        @elseif (Auth::user()->avatar !== '/storage/')
                            <img class="w-8 h-8 rounded-full" src="{{ asset('img/default-avatar.png') }}" alt="default">
                        @endif
                    @endauth
                    @guest
                        <img class="w-8 h-8 rounded-full" src="{{ asset('img/default-avatar.png') }}" alt="user photo">
                    @endguest
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                    id="user-dropdown">
                    <div class="px-4 py-3">
                        @auth
                            <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                            <span
                                class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
                        @endauth
                        @guest
                            <span class="block text-sm text-gray-900 dark:text-white">Guest@example.com</span>
                            <span class="block text-sm text-gray-500 truncate dark:text-gray-400">guest</span>
                        @endguest
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">

                        @auth
                            <li>
                                <button
                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200">
                                    <i class="fa fa-user"></i>
                                    <a href="/dashboard/edit-profile" class="ml-2">Profile</a>
                                </button>
                            </li>
                            <li>
                                <form action="{{ filament()->getLogoutUrl() }}" method="POST">
                                    @csrf
                                    <button
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200"><i
                                            class="fa fa-sign-out-alt"></i>
                                        <span class="ml-2">Logout</span></button>
                                </form>
                            </li>
                        @endauth
                        @guest
                            <li>
                                <button
                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200">
                                    <a href="/photos">Explore</a>
                                </button>
                            </li>
                            </li>
                            <li>
                                <button
                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200">
                                    <a href="/photos">Categories</a>
                                </button>
                            </li>
                            <li>
                                <button
                                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200">
                                    <a href="/dashboard">Dashboard</a>
                                </button>
                            </li>
                        @endguest
                    </ul>
                </div>
                <button data-collapse-toggle="navbar-user" type="button"
                    class="inline-flex items-center justify-center w-10 h-10 p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-user" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>

            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
                <ul
                    class="flex flex-col p-4 mt-4 font-medium bg-white border border-gray-100 rounded-lg md:p-0 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    {{-- <li>
                    <a href="/home"
                        class="block py-2 px-3   rounded md:bg-transparent {{ Request::is('home') || Request::is('/') ? 'text-blue-700' : 'text-gray-900' }} md:p-0">Home</a>
                </li> --}}
                    <li>
                        <div
                            class="px-4 py-2 {{ Request::is('photos*') || Request::is('/') ? ' bg-black rounded-full' : '' }}">
                            <a href="/photos"
                                class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent {{ Request::is('photos*') || Request::is('/') ? 'text-white ' : 'text-gray-900' }} md:p-0"
                                wire:navigate>Home</a>
                        </div>
                    </li>
                    <li>
                        <div class="px-4 py-2 {{ Request::is('albums*') ? ' bg-black rounded-full' : '' }}">
                            <a href="/albums"
                                class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent {{ Request::is('albums*') ? 'text-white' : 'text-gray-900' }} md:p-0"
                                wire:navigate>Albums</a>
                        </div>
                    </li>

                    <li>
                        <div class="px-4 py-2 {{ Request::is('categories*') ? ' bg-black rounded-full' : '' }}">
                            <a href="/categories"
                                class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent {{ Request::is('categories*') ? 'text-white' : 'text-gray-900' }} md:p-0"
                                wire:navigate>Categories</a>
                        </div>
                    </li>
                    <li>
                        <div class="px-4 py-2">
                            <a href="/dashboard"
                                class="block px-3 py-2 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Dashboard</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
