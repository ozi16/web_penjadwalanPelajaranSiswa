<?php
ob_start();

// Ambil data siswa dari tabel users (hanya yang id_level = 2)
$query = mysqli_query($koneksi, "
    SELECT users.*, kelas.nama_kelas,jurusan.nama_jurusan, siswa.jenis_kelamin,siswa.tanggal_lahir 
    FROM users users 
    LEFT JOIN kelas kelas ON users.id_kelas = kelas.id 
    LEFT JOIN jurusan ON users.id_jurusan = jurusan.id
    LEFT JOIN siswa ON users.id = siswa.user_id
    WHERE users.id_level = 2
");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$rowEdit = [
    'id' => '',
    'nis' => '',
    'nama' => '',
    'id_kelas' => '',
    'id_jurusan' => '',
    'jenis_kelamin' => '',
    'tanggal_lahir' => ''
];

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $editQuery = mysqli_query($koneksi, "
    SELECT users.*, siswa.jenis_kelamin, siswa.tanggal_lahir 
    FROM users 
    LEFT JOIN siswa ON users.id = siswa.user_id 
    WHERE users.id = $id
");
    if ($editQuery && mysqli_num_rows($editQuery) > 0) {
        $rowEdit = mysqli_fetch_assoc($editQuery);
    } else {
        echo "<div class='alert alert-danger'>Data tidak ditemukan</div>";
    }
}



?>


<div class="card">

    <h5 class="card-header flex-column ">Data Siswa</h5>
    <div align="right" class="mb-3 p-3">
        <button href="" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#tambahSiswa" aria-controls="tambahSiswa">Tambah</button>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>kelas</th>
                    <th>Jurusan</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="table-border-bottom-0">
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($query)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= isset($row['nis']) ? $row['nis'] : '' ?></td>
                        <td><?= isset($row['nama']) ? $row['nama'] : '' ?></td>
                        <td><?= isset($row['nama_kelas']) ? $row['nama_kelas'] : '' ?></td>
                        <td><?= isset($row['nama_jurusan']) ? $row['nama_jurusan'] : '' ?></td>
                        <td><?= isset($row['jenis_kelamin']) ? $row['jenis_kelamin'] : '' ?></td>
                        <td><?= isset($row['tanggal_lahir']) ? $row['tanggal_lahir'] : '' ?></td>

                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="?page=siswa&edit=<?php echo $row['id'] ?>"><i class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                                    <a class="dropdown-item" href="siswa_proses.php?delete=<?= $row['id'] ?>"><i class="icon-base bx bx-trash me-1"></i> Delete</a>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="tambahSiswa" aria-labelledby="tambahSiswaLabel">
    <div class="offcanvas-header">
        <h5 id="tambahSiswaLabel" class="offcanvas-title">Tambah Data Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="siswa_proses.php" method="POST">
            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" class="form-control" id="nis" name="nis" value="<?php echo isset($_GET['edit']) ? $rowEdit['nis'] : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Siswa</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo isset($_GET['edit']) ? $rowEdit['nama'] : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="id_kelas" class="form-label">Kelas</label>
                <select class="form-select" name="id_kelas" id="id_kelas" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php
                    // Ambil data kelas dari database
                    $kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
                    while ($k = mysqli_fetch_assoc($kelas)) {
                        echo "<option value='{$k['id']}' " . ($rowEdit['id_kelas'] == $k['id'] ? 'selected' : '') . ">{$k['nama_kelas']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_jurusan" class="form-label">Jurusan</label>
                <select class="form-select" name="id_jurusan" id="id_jurusan" required>
                    <option value="">-- Pilih Jurusan --</option>
                    <!-- mengambil data dari database -->
                    <?php
                    $jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
                    while ($j = mysqli_fetch_assoc($jurusan)) {
                        echo "<option value='{$j['id']}' " . ($rowEdit['id_jurusan'] == $j['id'] ? 'selected' : '') . ">{$j['nama_jurusan']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                    <option value="">-- Pilih Kelamin --</option>
                    <option value="Laki-laki" <?php echo ($rowEdit['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php echo ($rowEdit['jenis_kelamin'] ?? '') == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $rowEdit['tanggal_lahir'] ?? ''; ?>" required>
            </div>
            <input type="hidden" name="id_level" value="2">

            <?php if (isset($_GET['edit'])): ?>
                <input type="hidden" name="id" value="<?php echo $rowEdit['id']; ?>">
            <?php endif; ?>

            <?php if (isset($_GET['status']) && $_GET['status'] == 'edit_berhasil') : ?>
                <div class="alert alert-success">Data siswa berhasil diubah.</div>
            <?php endif; ?>

            <button name="<?php echo isset($_GET['edit']) ? 'edit' : 'add' ?>" type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<?php if (isset($_GET['edit'])) : ?>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            var myOffcanvas = new bootstrap.Offcanvas(document.getElementById('tambahSiswa'));
            myOffcanvas.show();
        });
    </script>
<?php endif; ?>