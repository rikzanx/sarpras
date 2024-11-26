<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets\img\sarpras.png')}}" height="55">
            </span>
        </a>

        <a href="javascript:void(0);"
            class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('dashboard*') ? 'active' : '' }}">
            <a href="{{route('dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Master</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('list_data_inventory_group*') ? 'active' : '' }}">
                    <a href="{{route('list_data_inventory_group')}}" class="menu-link">
                        <div data-i18n="Without menu">Inventory Group</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('list_data_barang*') ? 'active' : '' }}">
                    <a href="{{route('list_data_barang')}}" class="menu-link">
                        <div data-i18n="Without navbar">Item</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('list_data_satuan*') ? 'active' : '' }}">
                    <a href="{{route('list_data_satuan')}}" class="menu-link">
                        <div data-i18n="Container">Satuan</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Material Request</span>
        </li>

        <li class="menu-item {{ request()->is('list_data_pengajuan*') ? 'active' : '' }}">
            <a href="{{route('list_data_pengajuan')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-crown"></i>
                <div data-i18n="Boxicons">Pengajuan Barang</div>
            </a>
        </li>


        <!-- User -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">User</span></li>
        <li class="menu-item {{ request()->is('list_data_user*') ? 'active' : '' }}">
            <a href="{{route('list_data_user')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Documentation">User Management</div>
            </a>
        </li>




    </ul>
</aside>
