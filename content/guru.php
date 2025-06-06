<?php
ob_start();

// Ambil data guru dari tabel guru
$query = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY id ASC");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$rowEdit = [
    'id' => '',
    'nip' => '',
    'nama_guru' => ''

];

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $editQuery = mysqli_query($koneksi, "SELECT * FROM guru WHERE id = $id");
    if ($editQuery && mysqli_num_rows($editQuery) > 0) {
        $rowEdit = mysqli_fetch_assoc($editQuery);
    } else {
        echo "<div class='alert alert-danger'>Data tidak ditemukan</div>";
    }
}




?>


<div class="card">

    <h5 class="card-header flex-column ">Data Guru</h5>
    <div align="right" class="mb-3 p-3">
        <button href="" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#tambahGuru" aria-controls="tambahGuru">Tambah</button>
    </div>
    <div class="text-nowrap ">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Guru</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="table-border-bottom-0">
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($query)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= isset($row['nip']) ? $row['nip'] : '' ?></td>
                        <td><?= isset($row['nama_guru']) ? $row['nama_guru'] : '' ?></td>

                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="?page=guru&edit=<?php echo $row['id'] ?>"><i class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                                    <a class="dropdown-item" href="guru_proses.php?delete=<?= $row['id'] ?>"><i class="icon-base bx bx-trash me-1"></i> Delete</a>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="tambahGuru" aria-labelledby="tambahGuruLabel">
    <div class="offcanvas-header">
        <h5 id="tambahGuruLabel" class="offcanvas-title">Tambah Data Guru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="guru_proses.php" method="POST">
            <div class="mb-3">
                <label for="nis" class="form-label">NIP</label>
                <input type="text" class="form-control" id="nip" name="nip" value="<?php echo isset($_GET['edit']) ? $rowEdit['nip'] : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Guru</label>
                <input type="text" class="form-control" id="nama_guru" name="nama_guru" value="<?php echo isset($_GET['edit']) ? $rowEdit['nama_guru'] : '' ?>" required>
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
            var myOffcanvas = new bootstrap.Offcanvas(document.getElementById('tambahGuru'));
            myOffcanvas.show();
        });
    </script>
<?php endif; ?>