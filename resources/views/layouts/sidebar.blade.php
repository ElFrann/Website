<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Inventory DiranPlant</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pengaturan
    </div>

    <!-- Nav Item - Daftar Tanaman -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('inventories.index') }}">
            <i class="fas fa-fw fa-leaf"></i>
            <span>Daftar Tanaman</span>
        </a>
    </li>

    <!-- Nav Item - Stock Log -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('stock_logs.index') }}">
            <i class="fas fa-fw fa-exchange-alt"></i>
            <span>Stock Log</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Alur Gudang
            </div>

    <!-- Nav Item - Pembelian -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('pembelian.index') }}">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Pembelian</span>
        </a>
    </li>

    <!-- Nav Item - Penyetekan -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('penyetekan.index') }}">
            <i class="fas fa-fw fa-seedling"></i>
            <span>Penyetekan</span>
        </a>
    </li>

    <!-- Nav Item - Penjualan -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('penjualan.index') }}">
            <i class="fas fa-fw fa-cash-register"></i>
            <span>Penjualan</span>
        </a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="#">Login</a>
                <a class="collapse-item" href="#">Register</a>
                <a class="collapse-item" href="#">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="#">404 Page</a>
                <a class="collapse-item" href="#">Blank Page</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <!-- Removed Upgrade to Pro link as per user request -->

</ul>
<!-- End of Sidebar -->
