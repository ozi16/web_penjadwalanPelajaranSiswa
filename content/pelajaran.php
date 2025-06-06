<?php
ob_start();

// Ambil data pelajaran dari tabel users (hanya yang id_level = 2)
$query = mysqli_query($koneksi, "SELECT pelajaran.*, kategori_pelajaran.nama_kategori 
FROM pelajaran 
JOIN kategori_pelajaran ON pelajaran.id_kategori = kategori_pelajaran.id");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$rowEdit = [
    'id' => '',
    'nama_pelajaran' => '',
    'nama' => '',
    'id_kategori' => ''
];

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $editQuery = mysqli_query($koneksi, "SELECT * FROM pelajaran WHERE id = $id");
    if ($editQuery && mysqli_num_rows($editQuery) > 0) {
        $rowEdit = mysqli_fetch_assoc($editQuery);
    } else {
        echo "<div class='alert alert-danger'>Data tidak ditemukan</div>";
    }
}




?>


<div class="card">
    <h3 class="card-header flex-column ">Data Mata Pelajaran</h3>

    <div align="right" class="mb-3 p-3">
        <button href="" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#tambahPelajaran" aria-controls="tambahPelajaran">+ Tambah</button>
    </div>
    <h5 class="card-header flex-column ">Mapel Umum</h5>
    <div class="">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelajaran</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="table-border-bottom-0">
                <?php
                $no = 1;
                $queryUmum = mysqli_query($koneksi, "SELECT * FROM pelajaran WHERE id_kategori = 1");
                while ($row = mysqli_fetch_assoc($queryUmum)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= isset($row['nama_pelajaran']) ? $row['nama_pelajaran'] : '' ?></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="?page=Pelajaran&edit=<?php echo $row['id'] ?>"><i class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                                    <a class="dropdown-item" href="Pelajaran_proses.php?delete=<?= $row['id'] ?>"><i class="icon-base bx bx-trash me-1"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <h5 class="card-header flex-column mt-4 ">Mapel Lokal</h5>
    <div class="">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelajaran</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="table-border-bottom-0">
                <?php
                $no = 1;
                $queryLokal = mysqli_query($koneksi, "SELECT * FROM pelajaran WHERE id_kategori = 2");
                while ($row = mysqli_fetch_assoc($queryLokal)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= isset($row['nama_pelajaran']) ? $row['nama_pelajaran'] : '' ?></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="?page=Pelajaran&edit=<?php echo $row['id'] ?>"><i class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                                    <a class="dropdown-item" href="Pelajaran_proses.php?delete=<?= $row['id'] ?>"><i class="icon-base bx bx-trash me-1"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <h5 class="card-header flex-column mt-4 ">Mapel Konsentrasi Kejurusan</h5>
    <div class="">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelajaran</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="table-border-bottom-0">
                <?php
                $no = 1;
                $queryKhusus = mysqli_query($koneksi, "SELECT * FROM pelajaran WHERE id_kategori = 3");
                while ($row = mysqli_fetch_assoc($queryKhusus)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= isset($row['nama_pelajaran']) ? $row['nama_pelajaran'] : '' ?></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="?page=Pelajaran&edit=<?php echo $row['id'] ?>"><i class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                                    <a class="dropdown-item" href="Pelajaran_proses.php?delete=<?= $row['id'] ?>"><i class="icon-base bx bx-trash me-1"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <h5 class="card-header flex-column mt-4 ">Mapel Konsentrasi Keahlian</h5>
    <div class="">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelajaran</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="table-border-bottom-0">
                <?php
                $no = 1;
                $queryKhusus = mysqli_query($koneksi, "SELECT * FROM pelajaran WHERE id_kategori = 4");
                while ($row = mysqli_fetch_assoc($queryKhusus)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= isset($row['nama_pelajaran']) ? $row['nama_pelajaran'] : '' ?></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="?page=Pelajaran&edit=<?php echo $row['id'] ?>"><i class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                                    <a class="dropdown-item" href="Pelajaran_proses.php?delete=<?= $row['id'] ?>"><i class="icon-base bx bx-trash me-1"></i> Delete</a>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="tambahPelajaran" aria-labelledby="tambahPelajaranLabel">
    <div class="offcanvas-header">
        <h5 id="tambahPelajaranLabel" class="offcanvas-title">Tambah Data Pelajaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="Pelajaran_proses.php" method="POST">
            <div class="mb-3">
                <label for="nama_pelajaran" class="form-label">Nama Pelajaran</label>
                <input type="text" class="form-control" id="nama_pelajaran" name="nama_pelajaran" value="<?php echo isset($_GET['edit']) ? $rowEdit['nama_pelajaran'] : '' ?>" required>
            </div>

            <div class="mb-3">
                <label for="id_kategori" class="form-label">Kategori Mata Pelajaran</label>
                <select class="form-select" name="id_kategori" id="id_kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php
                    // Ambil data kategori_pelajaran dari database
                    $kategori = mysqli_query($koneksi, "SELECT * FROM kategori_pelajaran");
                    while ($k = mysqli_fetch_assoc($kategori)) {
                        echo "<option value='{$k['id']}'>{$k['nama_kategori']}</option>";
                    }
                    ?>
                </select>
            </div>

            <?php if (isset($_GET['edit'])): ?>
                <input type="hidden" name="id" value="<?php echo $rowEdit['id']; ?>">
            <?php endif; ?>

            <?php if (isset($_GET['status']) && $_GET['status'] == 'edit_berhasil') : ?>
                <div class="alert alert-success">Data Pelajaran berhasil diubah.</div>
            <?php endif; ?>

            <button name="<?php echo isset($_GET['edit']) ? 'edit' : 'add' ?>" type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<?php if (isset($_GET['edit'])) : ?>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            var myOffcanvas = new bootstrap.Offcanvas(document.getElementById('tambahPelajaran'));
            myOffcanvas.show();
        });
    </script>
<?php endif; ?>