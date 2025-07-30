<div class="topbar" role="banner">
    <button class="toggle" aria-label="Toggle navigation" aria-expanded="false" aria-controls="sidebar-navigation">
        <ion-icon name="menu-outline"></ion-icon>
    </button>
    <div class="topbar-text">
        <span>{{ $pageTitle ?? 'Dashboard' }}</span>
    </div>
    <div class="user" role="region" aria-label="User menu">
        <ion-icon name="person-circle-outline"></ion-icon>
        <div class="user-text">
            <span>{{ Auth::user()->type ?? 'Guest' }}</span>
        </div>
    </div>
    <div class="dropdown-logout">
        <button id="dropdown-icon" aria-haspopup="true" aria-expanded="false" aria-controls="dropdown-content"
            aria-label="User options">
            <ion-icon name="chevron-down-outline"></ion-icon>
        </button>
        <div class="dropdown-content" id="dropdown-content" role="menu" aria-hidden="true">
            <ion-icon name="log-out"></ion-icon>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-text" role="menuitem"
                    style="background: none; border: none; padding: 0; margin: 0; cursor: pointer; color: inherit; font: inherit;">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
