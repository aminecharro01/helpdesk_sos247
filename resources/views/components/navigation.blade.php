<nav id="navbar" class="navbar">
    <ul>
        @if(auth()->user()->role === 'admin')
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a></li>
            <li class="dropdown">
                <a href="#" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <i class="bi bi-gear me-2"></i>Admin
                    <i class="bi bi-chevron-down dropdown-indicator"></i>
                </a>
                <ul>
                    <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people me-2"></i>Users
                    </a></li>
                    <li><a href="{{ route('admin.tickets.index') }}" class="{{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                        <i class="bi bi-ticket-detailed me-2"></i>Tickets
                    </a></li>
                </ul>
            </li>
        @endif

        @if(auth()->user()->role === 'agent')
            <li><a href="{{ route('agent.dashboard') }}" class="{{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a></li>
            <li><a href="{{ route('agent.tickets.index') }}" class="{{ request()->routeIs('agent.tickets.*') ? 'active' : '' }}">
                <i class="bi bi-ticket-detailed me-2"></i>Tickets
            </a></li>
        @endif

        @if(auth()->user()->role === 'client')
            <li><a href="{{ route('client.dashboard') }}" class="{{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a></li>
            <li><a href="{{ route('client.tickets.index') }}" class="{{ request()->routeIs('client.tickets.*') ? 'active' : '' }}">
                <i class="bi bi-ticket-detailed me-2"></i>My Tickets
            </a></li>
            <li><a href="{{ route('client.tickets.create') }}" class="{{ request()->routeIs('client.tickets.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle me-2"></i>New Ticket
            </a></li>
        @endif

        <li class="dropdown">
            <a href="#" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle me-2"></i>{{ Auth::user()->name }}
                <i class="bi bi-chevron-down dropdown-indicator"></i>
            </a>
            <ul>
                <li><a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="bi bi-pencil-square me-2"></i>Edit Profile
                </a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav> 