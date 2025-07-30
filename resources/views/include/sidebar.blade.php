<style>
    .navigation {
        max-height: 100vh;
        overflow-y: hidden;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .navigation::-webkit-scrollbar {
        display: none;
    }
</style>


<nav class="navigation" id="sidebar-navigation" role="navigation" aria-label="Main navigation">
    <ul>
        <li>
            <a href="#" aria-label="Home">
                <span class="icon">
                    <img src="{{ asset('images/LOGO_FIX.png') }}" alt="Logo Kota Bogor" width="150">
                </span>
            </a>
        </li>

        <li>
            <a href="{{ route('dashboard') }}">
                <span class="icon">
                    <ion-icon name="speedometer"></ion-icon>
                </span>
                <span class="title">Dashboard</span>
            </a>
        </li>

        <li>
            <a href="{{ route('agenda.index') }}">
                <span class="icon">
                    <ion-icon name="calendar"></ion-icon>
                </span>
                <span class="title">Agenda</span>
            </a>
        </li>

        <li>
            <a href="{{ route('new') }}">
                <span class="icon">
                    <ion-icon name="add-circle"></ion-icon>
                </span>
                <span class="title">Tambah</span>
            </a>
        </li>

        <li>
            <a href="{{ route('laporan') }}">
                <span class="icon">
                    <ion-icon name="document-text"></ion-icon>
                </span>
                <span class="title">Laporan</span>
            </a>
        </li>

        @auth
            @if (auth()->user()->type === 'Admin')
                <li>
                    <a href="{{ route('user') }}">
                        <span class="icon">
                            <ion-icon name="person-circle"></ion-icon>
                        </span>
                        <span class="title">User</span>
                    </a>
                </li>
            @endif
        @endauth

        <li>
            <a href="{{ url('/settings') }}">
                <span class="icon">
                    <ion-icon name="settings"></ion-icon>
                </span>
                <span class="title">Settings</span>
            </a>
        </li>
    </ul>
</nav>
