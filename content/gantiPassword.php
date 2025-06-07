<?php
// Tampilkan pesan dari URL jika ada
if (isset($_GET['msg'])) {
    echo '<div class="alert alert-info alert-dismissible fade show" role="alert">'
        . htmlspecialchars($_GET['msg']) .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
?>

<div class="card shadow-sm border-primary">
    <div class="card-header bg-primary text-white mb-3">
        <h5 class="mb-0 text-white"><i class="bi bi-lock"></i> Ganti Password</h5>
    </div>
    <div class="card-body">
        <form action="gantiPassword_prosses.php" method="POST">
            <div class="mb-3">
                <label for="password_lama" class="form-label">Password Lama</label>
                <input type="password" class="form-control" id="password_lama" name="password_lama" required>
            </div>

            <div class="mb-3">
                <label for="password_baru" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="password_baru" name="password_baru" required>
            </div>

            <div class="mb-3">
                <label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" required>
            </div>

            <button type="submit" class="btn btn-primary"><i class="bi bi-key"></i> Ganti Password</button>
        </form>
    </div>
</div>