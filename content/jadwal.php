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

    <h5 class="card-header flex-column ">Jadwal kelas</h5>
    <div align="right" class="mb-3 p-3">
        <button href="" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#tambahJadwal" aria-controls="tambahJadwal">Tambah</button>
    </div>

    <div class=" text-nowrap">
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