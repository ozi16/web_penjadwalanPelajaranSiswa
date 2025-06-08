<?php
// Ambil id_kelas dari session
$id_kelas = $_SESSION['id_kelas'] ?? null;

// Pastikan id_kelas tersedia
if (!$id_kelas) {
    echo '<div class="alert alert-danger m-3">ID Kelas tidak ditemukan dalam sesi.</div>';
    return;
}

// Ambil data jadwal berdasarkan id_kelas dari session
$jadwalQuery = mysqli_query($koneksi, "
    SELECT jadwal.hari, jadwal.jam_mulai, jadwal.jam_selesai, pelajaran.nama_pelajaran, kelas.nama_kelas, guru.nama_guru
    FROM jadwal 
    JOIN pelajaran ON jadwal.id_pelajaran = pelajaran.id 
    JOIN kelas ON jadwal.id_kelas = kelas.id
    JOIN guru ON jadwal.id_guru = guru.id
    WHERE jadwal.id_kelas = $id_kelas
    ORDER BY FIELD(jadwal.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'), jadwal.jam_mulai
");

// Tampung jadwal per hari
$jadwalPerHari = [];
while ($row = mysqli_fetch_assoc($jadwalQuery)) {
    $hari = $row['hari'];
    if (!isset($jadwalPerHari[$hari])) {
        $jadwalPerHari[$hari] = [];
    }
    $jadwalPerHari[$hari][] = $row;
}
?>

<div class="card">
    <?php
    if (!empty($jadwalPerHari)) {
        echo '<div class="row mb-3 g-4 p-3">';
        foreach ($jadwalPerHari as $hari => $jadwalList) {
            echo '
            <div class="col-md-6">
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white"><i class="bi bi-calendar-event"></i> ' . htmlspecialchars($hari) . '</h5>
                        <span class="badge bg-light text-primary">' . htmlspecialchars($jadwalList[0]['nama_kelas']) . '</span>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">';
            foreach ($jadwalList as $jadwal) {
                echo '
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>' . htmlspecialchars($jadwal['nama_pelajaran']) . '</strong><br>
                                    <small class="text-muted"><i class="bi bi-clock"></i> ' . htmlspecialchars($jadwal['nama_guru'])  . '</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">' . date('H:i', strtotime($jadwal['jam_mulai'])) . ' - ' . date('H:i', strtotime($jadwal['jam_selesai'])) . '</span>
                            </li>';
            }
            echo '
                        </ul>
                    </div>
                </div>
            </div>';
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-warning m-3">Tidak ada jadwal ditemukan untuk kelas ini.</div>';
    }
    ?>
</div>