<header class="header header-sticky p-0 mb-4">
    <div class="container-fluid border-bottom px-4">
        <button class="header-toggler" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
            style="margin-inline-start: -14px;">
            <i class="bi bi-list"></i>
        </button>
        <ul class="header-nav d-none d-lg-flex">
            <li class="nav-item"><a
                    class="nav-link
                {{ request()->is('marketing') || request()->is('marketing') ? 'active' : '' }}
                "
                    href="{{ route('marketing') }}">Dashboard</a></li>
            <li class="nav-item"><a
                    class="nav-link
                {{ request()->is('customer') || request()->is('customer') ? 'active' : '' }}
                "
                    href="{{ route('customer') }}">Customer</a></li>
            <li class="nav-item"><a
                    class="nav-link
                {{ request()->is('order') ? 'active' : '' }}
                "
                    href="{{ route('order') }}">Customer's Order</a></li>

            <li class="nav-item"><a
                    class="nav-link
                {{ request()->is('order-report') ? 'active' : '' }}
                "
                    href="{{ route('order-report') }}">Order's Report</a></li>

        </ul>
        <ul class="header-nav ms-auto"></ul>
        <ul class="header-nav">
            <li class="nav-item dropdown">
                <button class="btn btn-link nav-link py-2 px-2 d-flex align-items-center" type="button"
                    aria-expanded="false" data-coreui-toggle="dropdown">
                    <i class="bi bi-sun-fill theme-icon-active">
                        <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-contrast"></use>
                    </i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem;">
                    <li>
                        <button class="dropdown-item d-flex align-items-center" type="button"
                            data-coreui-theme-value="light">
                            <svg class="icon icon-lg me-3 d-none">
                                <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-sun"></use>
                            </svg><i class="bi bi-sun-fill me-3"></i> Light
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center" type="button"
                            data-coreui-theme-value="dark">
                            <svg class="icon icon-lg me-3 d-none">
                                <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-moon"></use>
                            </svg><i class="bi bi-moon-fill me-3"></i> Dark
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center active" type="button"
                            data-coreui-theme-value="auto">
                            <svg class="icon icon-lg me-3 d-none">
                                <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-contrast"></use>
                            </svg><i class="bi bi-brilliance me-3"></i> Auto
                        </button>
                    </li>
                </ul>
            </li>
            <li class="nav-item py-1">
                <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#"
                role="button" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-md"><i class="avatar-img bi bi-person-circle"
                        src="assets/img/avatars/8.jpg" alt="{{ auth()->user()->name }}"></i></div>
            </a>
            <div class="dropdown-menu dropdown-menu-end pt-0">
                <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">
                    Name</div>
                <a class="dropdown-item">{{ auth()->user()->name }}</a>
                <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold my-2">
                    <div class="fw-semibold">Settings</div>
                </div>
                <a class="dropdown-item" href="{{ route('profile.setting') }}">
                    <i class="bi bi-person-gear me-3"></i> Profile</a>
                </a>
                <div class="dropdown-divider"></div><a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="return confirm('Yakin Ingin Logout ?')">
                    <i class="bi bi-door-open me-3"></i> Logout</a>
            </div>
        </li>
        </ul>
    </div>
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                @if (request()->is('marketing') || request()->is('marketing/*'))
                    <li class="breadcrumb-item">Marpolind</li>
                    <li class="breadcrumb-item active"><span>Dashboard</span>
                    </li>
                @elseif (request()->is('customer'))
                    <li class="breadcrumb-item">Marpolind</li>
                    <li class="breadcrumb-item active"><span>Customer</span>
                    </li>
                @elseif (request()->is('customer/create'))
                    <li class="breadcrumb-item">Marpolind</li>
                    <li class="breadcrumb-item"><a href="{{ route('customer') }}"
                            class="text-decoration-none">Customer</a></li>
                    <li class="breadcrumb-item active"><span>Add New Customer</span></li>
                @elseif (request()->is('customer/edit/*'))
                    <li class="breadcrumb-item">Marpolind</li>
                    <li class="breadcrumb-item"><a href="{{ route('customer') }}"
                            class="text-decoration-none">Customer</a></li>
                    <li class="breadcrumb-item active"><span>Edit Customer</span></li>
                @elseif (request()->is('order'))
                    <li class="breadcrumb-item">Marpolind</li>
                    <li class="breadcrumb-item active"><span>Customer's Order</span>
                    @elseif (request()->is('order/create'))
                    <li class="breadcrumb-item">Marpolind</li>
                    <li class="breadcrumb-item"><a href="{{ route('order') }}" class="text-decoration-none">Customer's
                            Order</a></li>
                    <li class="breadcrumb-item active"><span>Add New Order</span></li>
                @elseif (request()->is('order/show/*'))
                    <li class="breadcrumb-item">Marpolind</li>
                    <li class="breadcrumb-item"><a href="{{ route('order') }}" class="text-decoration-none">Customer's
                            Order</a></li>
                    <li class="breadcrumb-item active"><span>Detail Order</span></li>
                @elseif (request()->is('order/edit/*'))
                    <li class="breadcrumb-item">Marpolind</li>
                    <li class="breadcrumb-item"><a href="{{ route('order') }}" class="text-decoration-none">Customer's
                            Order</a></li>
                    <li class="breadcrumb-item active"><span>Edit Order</span></li>
                @elseif (request()->is('profile/setting'))
                    <li class="breadcrumb-item">Marpolind</li>
                    <li class="breadcrumb-item active"><span>Profile Setting</span>
                    </li>
                @elseif (request()->is('order-report'))
                    <li class="breadcrumb-item">Marpolind</li>
                    <li class="breadcrumb-item active"><span>Order's Report</span>
                    </li>
                @else
                    <li class="breadcrumb-item active"><span>Marpolind</span></li>
                @endif



            </ol>
        </nav>
    </div>
</header>
