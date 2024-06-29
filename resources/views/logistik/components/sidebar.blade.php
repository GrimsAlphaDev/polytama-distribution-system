<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <h4>LPPI</h4>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark"
            aria-label="Close"
            onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
        <li class="nav-item"><a
                class="nav-link
            {{ request()->is('logistik') ? 'active' : '' }}"
                href="{{ route('logistik') }}">
                <i class="bi bi-house-door me-3"></i> Dashboard</a></li>
        <li class="nav-item"><a
                class="nav-link
            {{ request()->is('logistik') ? 'active' : '' }}"
                href="{{ route('logistik.firstW') }}">
                <i class="bi bi-house-door me-3"></i> Penimbangan Pertama</a></li>
        
    </ul>
</div>
