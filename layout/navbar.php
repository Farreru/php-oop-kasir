<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="<?= route('dashboard') ?>" class="logo d-flex align-items-center">
            <img src="<?= assets('img/logo.png') ?>" alt="" />
            <span class="d-none d-lg-block">Kasir 7</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" onclick="profileMenuButton()" href="#" data-bs-toggle="dropdown" id="profile-button" aria-expanded="false" data-bs-target="profile-tab">
                    <img src="<?= assets('img/user_icon.png') ?>" alt="Profile" class="rounded-circle border" />
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?= $_SESSION['user']['nama'] ?></span> </a><!-- End Profile Iamge Icon -->

                <ul id="profile-tab" class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?= $_SESSION['user']['nama'] ?></h6>
                        <span><?= $_SESSION['user']['role'] ?></span>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>


                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?= route('logout') ?>">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
                <!-- End Profile Dropdown Items -->
            </li>
            <!-- End Profile Nav -->
        </ul>
    </nav>
    <!-- End Icons Navigation -->
</header>
<!-- End Header -->