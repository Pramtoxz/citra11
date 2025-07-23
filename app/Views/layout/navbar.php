<nav class="main-header navbar navbar-expand navbar-light bg-teal">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>


    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link text-white" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Messages Dropdown Menu -->
        <!-- Notifications Dropdown Menu -->

        <li class="nav-item dropdown">
            <a class="nav-link text-white" data-toggle="dropdown" href="#">
                <div class="d-flex align-items-center">
                    <img src="<?= base_url() ?>assets\img\dokter.png" class="img-circle elevation-2 mr-2"
                        alt="User Image" width="28" height="28">
                    <span class="d-none d-md-inline text-black">Admin</span>
                </div>

            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right bg-teal">
                <span class="dropdown-item dropdown-header text-white">Hallo, Admin</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item text-white" style="transition: background-color 0.3s;">
                    <i class="fas fa-user mr-2"></i> My Profile
                    <style>
                    .dropdown-item:hover {
                        background-color: black;
                    }
                    </style>
                </a>
                <a href="#" class="dropdown-item text-white" style="transition: background-color 0.3s;">
                    <i class="fas fa-cog mr-2"></i> Settings
                    <style>
                    .dropdown-item:hover {
                        background-color: black;
                    }
                    </style>
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= base_url('auth/logout') ?>" class="dropdown-item dropdown-footer btnLogout"
                    style="color: red; font-weight: bold; transition: background-color 0.3s;">
                    Logout
                    <style>
                    .dropdown-item:hover {
                        background-color: black;
                    }
                    </style>
                </a>
            </div>
        </li>

    </ul>
</nav>