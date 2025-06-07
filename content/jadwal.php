<?php
ob_start();

// Ambil data kelas dari tabel kelas
$query = mysqli_query($koneksi, "
    SELECT jadwal.*, kelas.nama_kelas, guru.nama_guru, pelajaran.nama_pelajaran
    FROM jadwal
    JOIN kelas ON jadwal.id_kelas = kelas.id
    JOIN guru ON jadwal.id_guru = guru.id
    JOIN pelajaran ON jadwal.id_pelajaran = pelajaran.id
    ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'), jam_mulai
");

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

$rowEdit = [
    'id' => '',
    'hari' => '',
    'jam_mulai' => '',
    'jam_selesai' => '',
    'nama_kelas' => '',
    'nama_guru' => '',
    'nama_pelajaran' => ''

];

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $editQuery = mysqli_query($koneksi, "SELECT * FROM jadwal WHERE id = $id");
    if ($editQuery && mysqli_num_rows($editQuery) > 0) {
        $rowEdit = mysqli_fetch_assoc($editQuery);
    } else {
        echo "<div class='alert alert-danger'>Data tidak ditemukan</div>";
    }
}







?>


<div class="card">
    <form method="GET" action="">
        <input type="hidden" name="page" value="jadwal">
        <div class="card-body mb-3">
            <div class="row gx-3 gy-2 align-items-center">
                <div class="col-md-3">
                    <label class="form-label" for="selectKelas">Kelas</label>
                    <select id="selectKelas" name="kelas" class="form-select color-dropdown">
                        <option value="">-- Pilih Kelas --</option>
                        <?php
                        $kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
                        while ($k = mysqli_fetch_assoc($kelas)) {
                            $selected = (isset($_GET['kelas']) && $_GET['kelas'] == $k['id']) ? 'selected' : '';
                            echo "<option value='{$k['id']}' $selected>{$k['nama_kelas']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="selectHari">Hari</label>
                    <select class="form-select placement-dropdown" id="selectHari" name="hari">
                        <option value="">-- Pilih Hari --</option>
                        <?php
                        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                        foreach ($hariList as $h) {
                            $selected = (isset($_GET['hari']) && $_GET['hari'] == $h) ? 'selected' : '';
                            echo "<option value='$h' $selected>$h</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block">Tampilkan</button>
                </div>

            </div>
        </div>
    </form>
    <?php
    if (isset($_GET['kelas']) || isset($_GET['hari'])) {
        $kelasFilter = isset($_GET['kelas']) && $_GET['kelas'] != '' ? "jadwal.id_kelas = '" . $_GET['kelas'] . "'" : '1';
        $hariFilter  = isset($_GET['hari']) && $_GET['hari'] != '' ? "jadwal.hari = '" . $_GET['hari'] . "'" : '1';

        // Gabungkan filter
        $filter = "$kelasFilter AND $hariFilter";

        // Ambil data jadwal
        $jadwalQuery = mysqli_query($koneksi, "
        SELECT jadwal.hari, jadwal.jam_mulai, jadwal.jam_selesai, pelajaran.nama_pelajaran, kelas.nama_kelas 
        FROM jadwal 
        JOIN pelajaran ON jadwal.id_pelajaran = pelajaran.id 
        JOIN kelas ON jadwal.id_kelas = kelas.id
        WHERE $filter
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
                                <small class="text-muted"><i class="bi bi-clock"></i> ' . htmlspecialchars($jadwal['jam_mulai']) . ' - ' . htmlspecialchars($jadwal['jam_selesai']) . '</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">' . date('H:i', strtotime($jadwal['jam_mulai'])) . '</span>
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
            echo '<div class="alert alert-warning m-3">Tidak ada jadwal ditemukan.</div>';
        }
    }
    ?>




    <h5 class="card-header flex-column ">Jadwal kelas</h5>


    <div align="right" class="mb-3 p-3">
        <button href="" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#tambahJadwal" aria-controls="tambahJadwal">Tambah</button>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <!-- <th>No</th> -->
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Kelas</th>
                    <th>Guru</th>
                    <th>Pelajaran</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="table-border-bottom-0">
                <?php $no = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                    <tr>

                        <td><?= $row['hari'] ?></td>
                        <td><?= $row['jam_mulai'] ?></td>
                        <td><?= $row['jam_selesai'] ?></td>
                        <td><?= $row['nama_kelas'] ?></td>
                        <td><?= $row['nama_guru'] ?></td>
                        <td><?= $row['nama_pelajaran'] ?></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="?page=jadwal&edit=<?= $row['id'] ?>"><i class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                                    <a class="dropdown-item" href="jadwal_proses.php?delete=<?= $row['id'] ?>"><i class="icon-base bx bx-trash me-1"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

        </table>
    </div>
</div>

<!-- Halaman Form -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="tambahJadwal" aria-labelledby="tambahJadwalLabel">
    <div class="offcanvas-header">
        <h5 id="tambahJadwalLabel" class="offcanvas-title">Tambah Jadwal kelas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="jadwal_proses.php" method="POST">
            <div class="mb-3">
                <label for="hari" class="form-label">Hari</label>
                <select name="hari" class="form-select" required>
                    <option value="">-- Pilih Hari --</option>
                    <?php
                    $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                    foreach ($hariList as $hari) {
                        $selected = (isset($_GET['edit']) && $rowEdit['hari'] == $hari) ? 'selected' : '';
                        echo "<option value='$hari' $selected>$hari</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                <input type="time" name="jam_mulai" class="form-control" required
                    value="<?php echo isset($_GET['edit']) ? $rowEdit['jam_mulai'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                <input type="time" name="jam_selesai" class="form-control" required
                    value="<?php echo isset($_GET['edit']) ? $rowEdit['jam_selesai'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="id_kelas" class="form-label">Kelas</label>
                <select name="id_kelas" class="form-select" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php
                    $kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
                    while ($k = mysqli_fetch_assoc($kelas)) {
                        $selected = (isset($_GET['edit']) && $rowEdit['id_kelas'] == $k['id']) ? 'selected' : '';
                        echo "<option value='{$k['id']}' $selected>{$k['nama_kelas']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="id_guru" class="form-label">Guru</label>
                <select name="id_guru" class="form-select" required>
                    <option value="">-- Pilih Guru --</option>
                    <?php
                    $guru = mysqli_query($koneksi, "SELECT * FROM guru");
                    while ($g = mysqli_fetch_assoc($guru)) {
                        $selected = (isset($_GET['edit']) && $rowEdit['id_guru'] == $g['id']) ? 'selected' : '';
                        echo "<option value='{$g['id']}' $selected>{$g['nama_guru']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="id_pelajaran" class="form-label">Pelajaran</label>
                <select name="id_pelajaran" class="form-select" required>
                    <option value="">-- Pilih Pelajaran --</option>
                    <?php
                    $pelajaran = mysqli_query($koneksi, "SELECT * FROM pelajaran");
                    while ($p = mysqli_fetch_assoc($pelajaran)) {
                        $selected = (isset($_GET['edit']) && $rowEdit['id_pelajaran'] == $p['id']) ? 'selected' : '';
                        echo "<option value='{$p['id']}'$selected>{$p['nama_pelajaran']}</option>";
                    }
                    ?>
                </select>
            </div>


            <?php if (isset($_GET['edit'])): ?>
                <input type="hidden" name="id" value="<?php echo $rowEdit['id']; ?>">
            <?php endif; ?>

            <?php if (isset($_GET['status']) && $_GET['status'] == 'edit_berhasil') : ?>
                <div class="alert alert-success">Jadwal siswa berhasil diubah.</div>
            <?php endif; ?>

            <button name="<?php echo isset($_GET['edit']) ? 'edit' : 'add' ?>" type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<?php if (isset($_GET['edit'])) : ?>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            var myOffcanvas = new bootstrap.Offcanvas(document.getElementById('tambahJadwal'));
            myOffcanvas.show();
        });
    </script>
<?php endif; ?>