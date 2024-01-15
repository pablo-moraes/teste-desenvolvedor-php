<header class="shadow-sm bg-white">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-center {{ request()->routeIs('home') ? 'active' : '' }}" aria-current="page" href="/home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center {{ request()->routeIs('view_products') ? 'active' : '' }}" href="{{ route('view_products') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center {{ request()->routeIs('view_orders') ? 'active' : '' }}" href="{{ route('view_orders') }}">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center {{ request()->routeIs('view_customers') ? 'active' : '' }}" href="{{ route('view_customers') }}">Customers</a>
                    </li>
                </ul>
                <div>
                    <div class="d-flex justify-content-lg-end justify-content-start gap-2 flex-column flex-lg-row">
                        <a href="#" class="text-decoration-none px-2 btn btn-primary">{{ __('Login') }}</a>
                        <a href="#" class="text-decoration-none px-2 btn btn-outline-secondary">{{ __('Sign Up') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
