<nav class="app-bottom-nav d-lg-none" id="appBottomNav" aria-label="Mobil navigáció">
    <a href="{{ route('home') }}" class="app-tab {{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i>
        <span>Főoldal</span>
    </a>
    <a href="{{ route('products.index') }}" class="app-tab {{ request()->routeIs('products.*') ? 'active' : '' }}">
        <i class="fa-solid fa-table-cells-large"></i>
        <span>Radiátorok</span>
    </a>
    <button type="button" class="app-tab app-tab-cart" data-bs-toggle="offcanvas" data-bs-target="#cartDrawer" aria-controls="cartDrawer">
        <span class="app-tab-icon-wrap">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="cart-badge app-tab-badge {{ ($cartCount ?? 0) ? '' : 'd-none' }}" data-cart-count>{{ $cartCount ?? 0 }}</span>
        </span>
        <span>Kosár</span>
    </button>
    <a href="{{ route('reviews.index') }}" class="app-tab {{ request()->routeIs('reviews.*') ? 'active' : '' }}">
        <i class="{{ request()->routeIs('reviews.*') ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
        <span>Vélemény</span>
    </a>
    <a href="{{ route('contact') }}" class="app-tab {{ request()->routeIs('contact') ? 'active' : '' }}">
        <i class="fa-solid fa-phone"></i>
        <span>Kapcsolat</span>
    </a>
</nav>
