<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-beam"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Elektronik Medical Record</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <li class="nav-item {{ request()->is('rekam-medis*') ? 'active' : '' }}">
        <a class="nav-link" href="/rekam-medis">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Rekam Medis</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ request()->is('pemberian-obat*') ? 'active' : '' }}">
        <a class="nav-link" href="/pemberian-obat">
            <i class="fas fa-fw fa-hand-holding-heart"></i>
            <span>Pemberian Obat</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item {{ request()->is('rujukan*') ? 'active' : '' }}">
        <a class="nav-link" href="/rujukan">
            <i class="fas fa-fw fa-notes-medical"></i>
            <span>Rujukan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        master Data
    </div>


    <!-- Nav Item - Charts -->
    <li class="nav-item {{ request()->is('obat*') ? 'active' : '' }}">
        <a class="nav-link" href="/obat">
            <i class="fas fa-fw fa-pills"></i>
            <span>Obat</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('pasien*') ? 'active' : '' }}">
        <a class="nav-link" href="/pasien">
            <i class="fas fa-fw fa-users"></i>
            <span>Pasien</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('user*') ? 'active' : '' }}">
        <a class="nav-link" href="/user">
            <i class="fas fa-fw fa-user"></i>
            <span>Users</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
