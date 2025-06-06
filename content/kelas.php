<?php
ob_start();

// Ambil data kelas dari tabel kelas
$query = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY id ASC");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$rowEdit = [
    'id' => '',
    'nama_kelas' => '',

];

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $editQuery = mysqli_query($koneksi, "SELECT * FROM kelas WHERE id = $id");
    if ($editQuery && mysqli_num_rows($editQuery) > 0) {
        $rowEdit = mysqli_fetch_assoc($editQuery);
    } else {
        echo "<div class='alert alert-danger'>Data tidak ditemukan</div>";
    }
}




?>


<div class="card">

    <h5 class="card-header flex-column ">Data kelas</h5>
    <div align="right" class="mb-3 p-3">
        <button href="" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#tambahkelas" aria-controls="tambahkelas">Tambah</button>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama kelas</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="table-border-bottom-0">
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($query)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= isset($row['nama_kelas']) ? $row['nama_kelas'] : '' ?></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="?page=kelas&edit=<?php echo $row['id'] ?>"><i class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                                    <a class="dropdown-item" href="kelas_proses.php?delete=<?= $row['id'] ?>"><i class="icon-base bx bx-trash me-1"></i> Delete</a>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="tambahkelas" aria-labelledby="tambahkelasLabel">
    <div class="offcanvas-header">
        <h5 id="tambahkelasLabel" class="offcanvas-title">Tambah Data kelas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="kelas_proses.php" method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama kelas</label>
                <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="<?php echo isset($_GET['edit']) ? $rowEdit['nama_kelas'] : '' ?>" required>
            </div>


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
            var myOffcanvas = new bootstrap.Offcanvas(document.getElementById('tambahkelas'));
            myOffcanvas.show();
        });
    </script>
<?php endif; ?>