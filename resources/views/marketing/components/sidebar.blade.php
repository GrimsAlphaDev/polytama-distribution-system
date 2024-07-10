<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <h4>MARPOLIND</h4>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark"
            aria-label="Close"
            onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
        <li class="nav-item"><a
                class="nav-link
            {{ request()->is('marketing') || request()->is('marketing/*') ? 'active' : '' }}"
                href="{{ route('marketing') }}">
                <i class="bi bi-house-door me-3"></i> Dashboard</a></li>

        <li class="nav-item"><a
                class="nav-link 
                {{ request()->is('customer') || request()->is('customer') ? 'active' : '' }}"
                href="{{ route('customer') }}">
                <i class="bi bi-people me-3"></i> Customers</a></li>

        <li class="nav-item"><a
                class="nav-link 
                {{ request()->is('customer.create') || request()->is('customer/create*') ? 'active' : '' }}"
                href="{{ route('customer.create') }}">
                <i class="bi bi-person-add me-3"></i> Add New Customer</a></li>

        <li class="nav-item"><a
                class="nav-link 
                {{ request()->is('order') || request()->is('order/show/*') || request()->is('order/edit/*') ? 'active' : '' }}"
                href="{{ route('order') }}">
                <i class="bi bi-newspaper me-3"></i> Customer's Order</a></li>

        <li class="nav-item"><a
                class="nav-link 
                {{ request()->is('order.create') || request()->is('order/create*') ? 'active' : '' }}"
                href="{{ route('order.create') }}">
                <i class="bi bi-file-earmark-plus me-3"></i> Add New Order</a></li>

        <li class="nav-item"><a
                class="nav-link 
                {{ request()->is('order-report') ? 'active' : '' }}"
                href="{{ route('order-report') }}">
                <i class="bi bi-file-earmark-bar-graph me-3"></i> Order's Report</a></li>

    </ul>
</div>
