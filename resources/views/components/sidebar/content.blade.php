<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">

    <x-sidebar.link title="Dashboard" href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <!-- Check Sheet and Report for Quality Unit and Quality Body based on roles -->
    @if (auth()->user()->department === 'quality_unit')
    @if (!in_array(auth()->user()->posisi, ['Manajer', 'SPV']))
        <!-- Quality Unit: Non-Manager/Supervisor - Show Check Sheet and Report for Product and Project -->
        <x-sidebar.dropdown title="Check Sheet">
            <x-slot name="icon">
                <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.link title="Product" href="{{ route('product.check') }}" :isActive="request()->routeIs('product.check')">
            </x-sidebar.link>
            <x-sidebar.link title="Project" href="{{ route('project.check') }}" :isActive="request()->routeIs('project.check')">
            </x-sidebar.link>
        </x-sidebar.dropdown>

        <x-sidebar.dropdown title="Report">
            <x-slot name="icon">
                <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.link title="Product" href="{{ route('product.report') }}" :isActive="request()->routeIs('product.report')">
            </x-sidebar.link>
            <x-sidebar.link title="Project" href="{{ route('project.report') }}" :isActive="request()->routeIs('project.report')">
            </x-sidebar.link>
        </x-sidebar.dropdown>
    @else
        <!-- Quality Unit: Manager/Supervisor - Show only Report for Product and Project -->
        <x-sidebar.dropdown title="Report">
            <x-slot name="icon">
                <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.link title="Product" href="{{ route('product.report') }}" :isActive="request()->routeIs('product.report')">
            </x-sidebar.link>
            <x-sidebar.link title="Project" href="{{ route('project.report') }}" :isActive="request()->routeIs('project.report')">
            </x-sidebar.link>
        </x-sidebar.dropdown>
    @endif

    <!-- History PICA Quality (for Quality Unit) -->
    <x-sidebar.link title="History PICA Quality" href="{{ route('pica.form') }}" :isActive="request()->routeIs('pica.form')">
        <x-slot name="icon">
            <x-css-board class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

@elseif (auth()->user()->department === 'quality_body')
    @if (!in_array(auth()->user()->posisi, ['Manajer', 'SPV']))
        <!-- Quality Body: Non-Manager/Supervisor - Show Check Sheet for Project and Report for Project -->
        <x-sidebar.dropdown title="Check Sheet">
            <x-slot name="icon">
                <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.link title="Project" href="{{ route('project.check.body') }}" :isActive="request()->routeIs('project.check.body')">
            </x-sidebar.link>
        </x-sidebar.dropdown>

        <x-sidebar.dropdown title="Report">
            <x-slot name="icon">
                <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.link title="Project" href="{{ route('project.body.report') }}" :isActive="request()->routeIs('project.body.report')">
            </x-sidebar.link>
        </x-sidebar.dropdown>
    @else
        <!-- Quality Body: Manager/Supervisor - Show only Report for Project -->
        <x-sidebar.dropdown title="Report">
            <x-slot name="icon">
                <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.link title="Project" href="{{ route('project.body.report') }}" :isActive="request()->routeIs('project.body.report')">
            </x-sidebar.link>
        </x-sidebar.dropdown>
    @endif


        <!-- History PICA Quality Dropdown (for Quality Body) -->
        <x-sidebar.dropdown title="History PICA Quality">
            <x-slot name="icon">
                <x-css-board class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <x-sidebar.link title="Customer/Supplier Problem" href="{{ route('pica.customer') }}" :isActive="request()->routeIs('pica.customer')">
            </x-sidebar.link>
            <x-sidebar.link title="Internal Problem" href="{{ route('pica.internal') }}" :isActive="request()->routeIs('pica.internal')">
            </x-sidebar.link>
        </x-sidebar.dropdown>
    @endif

    <!-- Customer Information Problem - Visible to All Users -->
    @if (auth()->user()->department === 'quality_unit')
    <!-- Jika pengguna berada di departemen quality_unit -->
    <x-sidebar.link title="Customer Information Problem" href="{{ route('problem.form') }}" :isActive="request()->routeIs('problem.form')">
        <x-slot name="icon">
            <x-css-danger class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

@elseif (auth()->user()->department === 'quality_body')
    <!-- Jika pengguna berada di departemen quality_body -->
    <x-sidebar.link title="Customer Information Problem" href="{{ route('problemBody.form') }}" :isActive="request()->routeIs('problemBody.form')">
        <x-slot name="icon">
            <x-css-danger class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
@endif

</x-perfect-scrollbar>
