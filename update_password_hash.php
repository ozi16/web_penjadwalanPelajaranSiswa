<?php
require 'koneksi.php'; // atau file koneksi database kamu

// Ambil semua user dari tabel users
$result = mysqli_query($koneksi, "SELECT id, password FROM users");

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $plainPassword = $row['password'];

    // Skip kalau sudah berupa hash
    if (strlen($plainPassword) > 50 && strpos($plainPassword, '$2y$') === 0) {
        continue;
    }

    // Hash password-nya
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    // Update ke database
    $update = mysqli_prepare($koneksi, "UPDATE users SET password = ? WHERE id = ?");
    mysqli_stmt_bind_param($update, "si", $hashedPassword, $id);
    mysqli_stmt_execute($update);
}

echo "Semua password berhasil diubah menjadi hash.";
