<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard.index') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/favicon/Logo.png') }}" alt="Vetly Logo"
                    style="width: 35px; height: 35px; object-fit: contain; filter: invert(40%) sepia(100%) saturate(500%) hue-rotate(200deg);">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Vetly</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item @yield('Dashboard') ">
            <a href="{{ route('dashboard.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>
        <li class="menu-item @yield('Pharmacy')">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-plus-medical"></i>
                <div data-i18n="Account Settings">Pharmacy</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('pharmacy.create') }}" class="menu-link">
                        <div data-i18n="Account">Create</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('pharmacy.show') }}" class="menu-link">
                        <div data-i18n="Connections">Show</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item @yield('Orders')">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cart"></i>
                <div data-i18n="Authentications">Orders</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('orders.index') }}" class="menu-link">
                        <div data-i18n="Basic">Show</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item @yield('Clinic')">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-clinic"></i>
                <div data-i18n="Misc">Clinics</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('clinic.create') }}" class="menu-link">
                        <div data-i18n="Error">Create</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('clinic.show') }}" class="menu-link">
                        <div data-i18n="Under Maintenance">Show</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item @yield('Vaccination')">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-health"></i>
                <div data-i18n="Extended UI">Vaccinations</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('vaccination.create') }}" class="menu-link">
                        <div data-i18n="Perfect Scrollbar">Create</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('vaccination.show') }}" class="menu-link">
                        <div data-i18n="Text Divider">Show</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item @yield('Booking')">
            <a href="{{ route('booking.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Tables">Booking</div>
            </a>
        </li>
    </ul>
</aside>
<!-- / Menu -->
