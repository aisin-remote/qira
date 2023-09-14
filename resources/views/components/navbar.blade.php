<nav aria-label="secondary" x-data="{ open: false }" class="sticky top-0 z-10 flex items-center justify-between px-4 py-4 sm:px-6 transition-transform duration-500 bg-white dark:bg-dark-eval-1" :class="{
    '-translate-y-full': scrollingDown,
    'translate-y-0': scrollingUp,
}">

    <div class="flex items-center gap-3">
    </div>

    <div class="relative" x-data="{ open: false }" x-on:click.away="open = false" x-on:close.stop="open = false">
        <div x-on:click="open = !open" class="cursor-pointer">
            <button class="flex items-center p-2 text-sm font-medium text-gray-500 rounded-md transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none focus:ring focus:ring-purple-500 focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark-eval-1 dark:text-gray-400 dark:hover:text-gray-200">
                <div>{{ Auth::user()->name }}</div>

                <div class="ml-1">
                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
        </div>

        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 mt-2 right-0 w-48 rounded-lg shadow-lg" style="display: none;" x-on:click="open = false">
            <div class="bg-white dark:bg-dark-eval-2">
                <!-- Dropdown Items -->
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-dark-eval-3">Profile</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-100 hover:text-red-900 focus:outline-none focus:ring focus:ring-red-300 dark:text-red-400 dark:hover:bg-red-700 dark:hover:text-red-100">Log Out</button>
                </form>
            </div>
        </div>
    </div>

</nav>

<!-- Mobile bottom bar -->
<div class="fixed inset-x-0 bottom-0 flex items-center justify-between px-4 py-4 sm:px-6 transition-transform duration-500 bg-white md:hidden dark:bg-dark-eval-1" :class="{
        'translate-y-full': scrollingDown,
        'translate-y-0': scrollingUp,
    }">

    <a href="{{ route('dashboard') }}">
        <x-application-logo aria-hidden="true" class="w-10 h-10" />

        <span class="sr-only">Dashboard</span>
    </a>

    <x-button type="button" icon-only variant="secondary" sr-text="Open main menu" x-on:click="isSidebarOpen = !isSidebarOpen">
        <x-heroicon-o-menu x-show="!isSidebarOpen" aria-hidden="true" class="w-6 h-6" />

        <x-heroicon-o-x x-show="isSidebarOpen" aria-hidden="true" class="w-6 h-6" />
    </x-button>
</div>