<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <h4>TRANSPOLIND</h4>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark"
            aria-label="Close"
            onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
        <li class="nav-item"><a
                class="nav-link
            {{ request()->is('transporter') || request()->is('transporter/*') ? 'active' : '' }}"
                href="{{ route('transporter') }}">
                <i class="bi bi-house-door me-3"></i> Dashboard</a></li>
        <li class="nav-item"><a
                class="nav-link
            {{ request()->is('armada') ? 'active' : '' }}"
                href="{{ route('armada') }}">
                <i class="bi bi-truck me-3"></i></i> Armada</a></li>
        <li class="nav-item"><a
                class="nav-link
            {{ request()->is('armada/create') ? 'active' : '' }}"
                href="{{ route('armada.create') }}">
                <i class="bi bi-truck-flatbed me-3"></i> Tambah Armada</a></li>
    </ul>
</div>
