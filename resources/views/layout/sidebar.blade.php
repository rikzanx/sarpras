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

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">ISMS</span>
        </li>
        <li class="menu-item {{ request()->is('isms/list_transaksi*') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-archive"></i>
                <div data-i18n="Layouts">Transaksi</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('isms/list_transaksi_barang_masuk*') ? 'active' : '' }}">
                    <a href="{{route('isms_list_transaksi_barang_masuk')}}" class="menu-link">
                        <div data-i18n="Without navbar">Barang Masuk <span class="tf-icons bx bx-archive-in"></span></div>
                    </a>
                </li>
                
                <li class="menu-item {{ request()->is('isms/list_transaksi_barang_keluar*') ? 'active' : '' }}">
                    <a href="{{route('isms_list_transaksi_barang_keluar')}}" class="menu-link">
                        <div data-i18n="Container">Barang Keluar <span class="tf-icons bx bx-archive-out"></span></div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ request()->is('isms/stock_barang*') ? 'active' : '' }}">
            <a href="{{route('isms_stock_barang')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-line-chart"></i>
                <div data-i18n="Documentation">Stock</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('isms/list_data_barang*') ? 'active' : '' }}">
            <a href="{{route('isms_list_data_barang')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div data-i18n="Documentation">List Barang</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">ATK</span>
        </li>
        <li class="menu-item {{ request()->is('atk/list_transaksi*') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-archive"></i>
                <div data-i18n="Layouts">Transaksi</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('atk/list_transaksi_barang_masuk*') ? 'active' : '' }}">
                    <a href="{{route('atk_list_transaksi_barang_masuk')}}" class="menu-link">
                        <div data-i18n="Without navbar">Barang Masuk <span class="tf-icons bx bx-archive-in"></span></div>
                    </a>
                </li>
                
                <li class="menu-item {{ request()->is('atk/list_transaksi_barang_keluar*') ? 'active' : '' }}">
                    <a href="{{route('atk_list_transaksi_barang_keluar')}}" class="menu-link">
                        <div data-i18n="Container">Barang Keluar <span class="tf-icons bx bx-archive-out"></span></div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ request()->is('atk/stock_barang*') ? 'active' : '' }}">
            <a href="{{route('atk_stock_barang')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-line-chart"></i>
                <div data-i18n="Documentation">Stock</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('atk/list_data_barang*') ? 'active' : '' }}">
            <a href="{{route('atk_list_data_barang')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div data-i18n="Documentation">List Barang</div>
            </a>
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

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Master Data</span>
        </li>
        <li class="menu-item {{ request()->is('list_data_barang*') || request()->is('list_data_group*') || request()->is('list_data_satuan*') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Master</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('list_data_barang*') ? 'active' : '' }}">
                    <a href="{{route('list_data_barang')}}" class="menu-link">
                        <div data-i18n="Without navbar">Barang</div>
                    </a>
                </li>
                
                <li class="menu-item {{ request()->is('list_data_satuan*') ? 'active' : '' }}">
                    <a href="{{route('list_data_satuan')}}" class="menu-link">
                        <div data-i18n="Container">Satuan</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('list_data_group*') ? 'active' : '' }}">
                    <a href="{{route('list_data_group')}}" class="menu-link">
                        <div data-i18n="Without menu">Group</div>
                    </a>
                </li>
            </ul>
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
