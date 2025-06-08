<?php

// Ambil informasi user dari session
$nama = $_SESSION['nama'];
$level = $_SESSION['id_level'];

$id_kelas = $_SESSION['id_kelas'] ?? null;

$hari = $_GET['hari'] ?? 'Senin'; // aman dari error


// Menampilkan data jumlah mapel
$queryMapel = mysqli_query($koneksi, "
    SELECT COUNT(DISTINCT pelajaran.id) AS total 
    FROM jadwal
    JOIN pelajaran ON jadwal.id_pelajaran = pelajaran.id
    WHERE jadwal.id_kelas = $id_kelas
");

$dataMapel = mysqli_fetch_assoc($queryMapel);
$totalMapel = $dataMapel['total'];

// Pastikan hari dan id_kelas tidak kosong
if (!empty($hari) && !empty($id_kelas)) {

    // Gunakan sanitasi data
    $hari = mysqli_real_escape_string($koneksi, $hari);
    $id_kelas = intval($id_kelas); // pastikan id_kelas berupa angka

    $query = mysqli_query($koneksi, "
        SELECT jadwal.jam_mulai, jadwal.jam_selesai, pelajaran.nama_pelajaran, guru.nama_guru
        FROM jadwal
        JOIN pelajaran ON jadwal.id_pelajaran = pelajaran.id
        JOIN guru ON jadwal.id_guru = guru.id
        WHERE jadwal.hari = '$hari' AND jadwal.id_kelas = $id_kelas
        ORDER BY jadwal.jam_mulai
    ");
}

// list group / date
date_default_timezone_set('Asia/Jakarta');
$tanggal_sekarang = date('j');
$bulan_sekarang = date('F Y');
$hari_ini = date('l');

$hari_map = [
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu',
    'Sunday' => 'Minggu'
];
$hari_db = $hari_map[$hari_ini];

// Query jadwal hari ini
$query_today = mysqli_query($koneksi, "SELECT * FROM jadwal 
    INNER JOIN pelajaran ON jadwal.id_pelajaran = pelajaran.id 
    INNER JOIN guru ON jadwal.id_guru = guru.id 
    WHERE jadwal.hari = '$hari_db' AND jadwal.id_kelas = '$id_kelas'
    ORDER BY jam_mulai ASC");


// Hari dan waktu sekarang
$hari_map = [
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu',
    'Sunday' => 'Minggu'
];
$hari_ini = $hari_map[date('l')];
$jam_sekarang = date('H:i');

// Query pelajaran yang sedang berlangsung saat ini
$query_now = mysqli_query($koneksi, "
    SELECT pelajaran.nama_pelajaran, guru.nama_guru, jadwal.jam_mulai, jadwal.jam_selesai 
    FROM jadwal 
    INNER JOIN pelajaran ON jadwal.id_pelajaran = pelajaran.id 
    INNER JOIN guru ON jadwal.id_guru = guru.id 
    WHERE jadwal.hari = '$hari_ini' 
    AND jadwal.id_kelas = '$id_kelas'
    AND '$jam_sekarang' >= jadwal.jam_mulai 
    AND '$jam_sekarang' < jadwal.jam_selesai
    LIMIT 1
");


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

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .doctor-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .icon-action i {
        margin: 0 5px;
        cursor: pointer;
    }

    .calendar .active {
        background-color: #007bff;
        color: white;
    }

    .calendar .list-group-item {
        border: none;
    }

    .list-hover:hover {
        background-color: #e6f5ea !important;
        transform: scale(1.02);
        transition: all 0.2s ease;
    }
</style>

<div class="row mb-4">
    <div class="col-12">
        <div class="card text-white bg-primary shadow">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="card-title mb-2 text-white">Hello, <span id="nama-user "><?= $nama ?></span> 🎉</h3>
                    <p class="mb-0 ">Semoga harimu menyenangkan dan produktif!</p>
                </div>
                <img src="assets/assets/img/illustrations/man-with-laptop-light.png" height="100" class="bounce" alt="Welcome">
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">


    <div class="col-md-6 col-lg-3">
        <div class="card card-hover text-center shadow-sm">
            <div class="card-body">
                <img src="assets/assets/img/icons/unicons/totalMapel.png" height="40" alt="Mapel" class="mb-2">
                <h5 class="fw-bold">Total Mapel</h5>
                <h3 class="text-warning" id="total-mapel"><?php echo $totalMapel; ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">

    <!-- Left Column: Upcoming Appointments & Available Doctors -->
    <div class="col-lg-8">
        <!-- Upcoming Appointment -->
        <div class="card p-4 mb-4 ">
            <form method="GET" class="d-flex align-items-center mb-3">
                <h5 class="me-3 mb-0">Jadwal Pelajaran</h5>
                <select class="form-select w-auto" name="hari" onchange="this.form.submit()">
                    <option value="">Pilih Hari</option>
                    <option value="Senin" <?= ($hari == 'Senin') ? 'selected' : '' ?>>Senin</option>
                    <option value="Selasa" <?= ($hari == 'Selasa') ? 'selected' : '' ?>>Selasa</option>
                    <option value="Rabu" <?= ($hari == 'Rabu') ? 'selected' : '' ?>>Rabu</option>
                    <option value="Kamis" <?= ($hari == 'Kamis') ? 'selected' : '' ?>>Kamis</option>
                    <option value="Jumat" <?= ($hari == 'Jumat') ? 'selected' : '' ?>>Jumat</option>
                </select>
            </form>


            <table class="table table-hover table-striped table-bordered align-middle shadow-sm rounded">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Pelajaran</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Guru</th>
                    </tr>
                </thead>
                <?php if (!empty($hari) && isset($query) && mysqli_num_rows($query) > 0): ?>
                    <tbody class="text-center">
                        <?php while ($row = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td class="fw-semibold"><?= $row['nama_pelajaran'] ?></td>
                                <td><?= $row['jam_mulai'] ?></td>
                                <td><?= $row['jam_selesai'] ?></td>
                                <td class="text-capitalize"><?= $row['nama_guru'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                <?php elseif (!empty($hari)): ?>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada jadwal untuk hari ini.</td>
                        </tr>
                    </tbody>
                <?php endif; ?>
            </table>

        </div>
    </div>

    <!-- Right Column: Calendar -->
    <div class="col-lg-4">
        <div class="card p-4 calendar shadow-sm rounded">
            <h5 class="mb-3">Date</h5>
            <div class="text-muted mb-2"><?= $bulan_sekarang ?></div>


            <div class="d-flex justify-content-between mb-3 fw-semibold text-primary">
                <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
            </div>

            <!-- Hari-hari bulan ini -->
            <div class="d-flex flex-wrap gap-2 mb-4">
                <?php for ($i = 1; $i <= 30; $i++): ?>
                    <span class="<?= $i == $tanggal_sekarang ? 'bg-primary text-white px-2 py-1 rounded' : '' ?>">
                        <?= $i ?>
                    </span>
                <?php endfor; ?>
            </div>
            <div class="text-muted mb-2"><?= $hari_ini . ', ' . date('H:i') ?></div>
            <!-- Appointment List -->
            <!-- <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center bg-light rounded mb-2">
                    <div>
                        <strong> Hari</strong><br>
                        <small>Pelajaran</small>
                    </div>
                    <span class="badge bg-primary rounded-pill">Jam mulai</span>
                </li>
            </ul> -->
            <ul class="list-group">
                <?php if (mysqli_num_rows($query_now) > 0): ?>
                    <?php $row = mysqli_fetch_assoc($query_now); ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-light rounded shadow-sm list-hover">
                        <div>
                            <strong><?= $row['nama_pelajaran'] ?></strong><br>
                            <small class="text-muted"><?= $row['nama_guru'] ?></small>
                        </div>
                        <span class="badge bg-success rounded-pill"><?= $row['jam_mulai'] ?> - <?= $row['jam_selesai'] ?></span>
                    </li>
                <?php else: ?>
                    <li class="list-group-item text-muted text-center">
                        Tidak ada pelajaran berlangsung saat ini.
                    </li>
                <?php endif; ?>
            </ul>

        </div>
    </div>

</div>