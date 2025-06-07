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
// menampilkan data jumlah mapel
$queryMapel = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pelajaran");
$dataMapel = mysqli_fetch_assoc($queryMapel);
$totalMapel = $dataMapel['total'];


?>
<style>
    .card-hover:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease-in-out;
    }

    .bounce {
        animation: bounce 2s infinite;
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-8px);
        }
    }
</style>

<div class="row mb-4">
    <div class="col-12">
        <div class="card text-white bg-primary shadow">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="card-title mb-2 text-white">Selamat Datang, <span id="nama-user" class="text-info"><?= $nama ?></span> 🎉</h3>
                    <p class="mb-0 ">Semoga harimu menyenangkan dan produktif!</p>
                </div>
                <img src="assets/assets/img/illustrations/man-with-laptop-light.png" height="100" class="bounce" alt="Welcome">
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6 col-lg-3">
        <div class="card card-hover text-center shadow-sm">
            <div class="card-body">
                <img src="https://cdn-icons-png.flaticon.com/512/1995/1995574.png" height="40" alt="Guru" class="mb-2">
                <h5 class="fw-bold">Total Guru</h5>
                <h3 class="text-primary" id="total-guru"><?php echo $totalGuru; ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card card-hover text-center shadow-sm">
            <div class="card-body">
                <img src="assets/assets/img/icons/unicons/totalSiswa.png" height="40" alt="Siswa" class="mb-2">
                <h5 class="fw-bold">Total Siswa</h5>
                <h3 class="text-success" id="total-siswa"><?php echo $totalSiswa; ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card card-hover text-center shadow-sm">
            <div class="card-body">
                <img src="assets/assets/img/icons/unicons/totalMapel.png" height="40" alt="Mapel" class="mb-2">
                <h5 class="fw-bold">Total Mapel</h5>
                <h3 class="text-warning" id="total-mapel"><?php echo $totalMapel; ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card card-hover text-center shadow-sm">
            <div class="card-body">
                <img src="assets/assets/img/icons/unicons/totalKelas.png" height="40" alt="Kelas" class="mb-2">
                <h5 class="fw-bold">Total Kelas</h5>
                <h3 class="text-danger" id="total-kelas"><?php echo $totalKelas; ?></h3>
            </div>
        </div>
    </div>
</div>