<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
           <code class="logo">{{env('APP_NAME', 'Artist Management System')}}</code>
        </a>

        <!-- Hamburger Button (for Mobile View) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links and Dropdown -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Navigation Links -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        {{ __('Dashboard') }}
                    </a>
                </li>
                @can('view',auth()->user())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            {{ __('Users') }}
                        </a>
                    </li>
                @endcan

                @can('view',new \App\Models\Artist)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('artists.index','artists.create','artists.show','artists.edit','artists.music') ? 'active' : '' }}" href="{{ route('artists.index') }}">
                            {{ __('Artist') }}
                        </a>
                    </li>
                @endcan

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('music.index','music.show','music.create','music.edit') ? 'active' : '' }}" href="{{ route('music.index') }}">
                        {{ __('Music') }}
                    </a>
                </li>
            </ul>

            <!-- Settings Dropdown -->
            <ul class="navbar-nav ms-auto">
                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm logout-button" type="submit">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
