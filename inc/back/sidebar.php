<style>
    .sidebar-logo {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 50%;
        transition: transform 0.3s ease;
    }

    .sidebar-logo:hover {
        transform: scale(1.05);
    }

    .app-brand-text {
        font-size: 1.1rem;
        color: #333;
        white-space: nowrap;
    }

    .app-brand-link {
        display: flex;
        align-items: center;
    }

    @media (max-width: 768px) {
        .app-brand-text {
            display: none;
            /* Sembunyikan tulisan saat layar kecil */
        }
    }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo d-flex align-items-center justify-content-center py-3">
        <a href="index.html" class="app-brand-link d-flex align-items-center text-decoration-none">
            <img src="assets/img/logopplgcn.png" class="sidebar-logo" alt="Logo SMK Citra Negara">
            <span class="app-brand-text fw-semibold  text-truncate">SMK Citra Negara</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item <?= (isset($_GET['page']) && $_GET['page'] == 'dashboard') ? 'active' : '' ?>">
            <a href="?page=dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Master Data -->
        <?php
        // Cek apakah halaman aktif merupakan bagian dari menu "Master Data"
        $isMasterActive = isset($_GET['page']) && in_array($_GET['page'], ['siswa', 'guru', 'kelas', 'pelajaran']);
        $isJadwalActive = isset($_GET['page']) && in_array($_GET['page'], ['jadwal']);

        ?>

        <li class="menu-item <?= $isMasterActive ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Master Data</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item <?= (isset($_GET['page']) && $_GET['page'] == 'siswa') ? 'active' : '' ?>">
                    <a href="?page=siswa" class="menu-link">
                        <div data-i18n="Without menu">Data Siswa</div>
                    </a>
                </li>
                <li class="menu-item <?= (isset($_GET['page']) && $_GET['page'] == 'guru') ? 'active' : '' ?> ">
                    <a href="?page=guru" class="menu-link">
                        <div data-i18n="Without navbar">Data Guru</div>
                    </a>
                </li>
                <li class="menu-item <?= (isset($_GET['page']) && $_GET['page'] == 'pelajaran') ? 'active' : '' ?>">
                    <a href="?page=pelajaran" class="menu-link">
                        <div data-i18n="Container">Data Pelajaran</div>
                    </a>
                </li>
                <li class="menu-item <?= (isset($_GET['page']) && $_GET['page'] == 'kelas') ? 'active' : '' ?>">
                    <a href="?page=kelas" class="menu-link">
                        <div data-i18n="Fluid">Data Kelas</div>
                    </a>
                </li>

            </ul>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Penjadwalan</span>
        </li>
        <li class="menu-item <?= $isJadwalActive ? 'active open' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Penjadwalan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= (isset($_GET['page']) && $_GET['page'] == 'jadwal') ? 'active' : '' ?>">
                    <a href="?page=jadwal" class="menu-link">
                        <div data-i18n="Account">Atur Jadwal</div>
                    </a>
                </li>

            </ul>
        </li>

        <!-- pengaturan -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Pengaturan</span></li>
        <!-- Cards -->

        <li class="menu-item <?= (isset($_GET['page']) && $_GET['page'] == 'gantiPassword') ? 'active' : '' ?>">
            <a href="?page=gantiPassword" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Ganti Password</div>
            </a>
        </li>


        <li class="menu-item">
            <a href="logout.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Logout</div>
            </a>
        </li>

    </ul>
</aside>