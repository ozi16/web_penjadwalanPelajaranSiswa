<?php
// Ambil informasi user dari session
$nama = $_SESSION['nama'];
$level = $_SESSION['id_level'];

// menampilkan data jumlah guru
$queryGuru = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM guru");
$dataGuru = mysqli_fetch_assoc($queryGuru);
$totalGuru = $dataGuru['total'];
// menampilkan data siswa
$querySiswa = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM users WHERE id_level = '2'");
$dataSiswa = mysqli_fetch_assoc($querySiswa);
$totalSiswa = $dataSiswa['total'];
// menampilkan data jumlah kelas
$queryKelas = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kelas");
$dataKelas = mysqli_fetch_assoc($queryKelas);
$totalKelas = $dataKelas['total'];


?>

<div class="row">
    <div class="col-xxl-8 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-start row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Selamat Datang <?= $nama ?> 🎉</h5>
                        <p class="mb-4">
                            You have done <span class="fw-bold">72%</span> more sales today. Check your new badge in
                            your profile.
                        </p>

                        <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img
                            src="assets/assets/img/illustrations/man-with-laptop-light.png"
                            height="140"
                            alt="View Badge User"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-lg-12 col-md-4 order-1">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img
                                    src="assets/assets/img/icons/unicons/chart-success.png"
                                    alt="chart success"
                                    class="rounded" />
                            </div>

                        </div>
                        <span class="fw-semibold d-block mb-1">Total Guru</span>
                        <h3 class="card-title mb-2"><?php echo $totalGuru; ?></h3>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img
                                    src="assets/assets/img/icons/unicons/wallet-info.png"
                                    alt="Credit Card"
                                    class="rounded" />
                            </div>

                        </div>
                        <span>Total Siswa</span>
                        <h3 class="card-title text-nowrap mb-1"><?php echo $totalSiswa; ?></h3>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img
                                    src="assets/assets/img/icons/unicons/wallet-info.png"
                                    alt="Credit Card"
                                    class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button
                                    class="btn p-0"
                                    type="button"
                                    id="cardOpt6"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>

                            </div>
                        </div>
                        <span>Total Mata Pelajaran</span>
                        <h3 class="card-title text-nowrap mb-1">$4,679</h3>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img
                                    src="assets/assets/img/icons/unicons/wallet-info.png"
                                    alt="Credit Card"
                                    class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button
                                    class="btn p-0"
                                    type="button"
                                    id="cardOpt6"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>

                            </div>
                        </div>
                        <span>Total Kelas</span>
                        <h3 class="card-title text-nowrap mb-1">$4,679</h3>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>