<?php
include 'koneksi.php';

// Cek apakah form disubmit
if (isset($_POST['add']) || isset($_POST['edit'])) {
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $id_kelas = intval($_POST['id_kelas']);
    $id_jurusan = intval($_POST['id_jurusan']);
    $id_level = 2; // siswa

    // Untuk default password (misal: nis)
    $default_password = password_hash($nis, PASSWORD_DEFAULT);

    if (isset($_POST['add'])) {
        $query = mysqli_query($koneksi, "INSERT INTO users (nis, nama, password, id_kelas, id_jurusan, id_level) 
        VALUES ('$nis', '$nama', '$default_password', $id_kelas, $id_jurusan, $id_level)");

        if ($query) {
            header("Location: index.php?page=siswa&tambah=success");
            exit;
        } else {
            echo "Gagal menambahkan data siswa: " . mysqli_error($koneksi);
        }
    }

    if (isset($_POST['edit'])) {
        $id = intval($_POST['id']);

        $query = mysqli_query($koneksi, "UPDATE users SET 
            nis = '$nis',
            nama = '$nama',
            id_kelas = $id_kelas,
            id_jurusan = $id_jurusan,
            id_level = $id_level
            WHERE id = $id");

        if ($query) {
            header("Location: index.php?page=siswa&status=edit_berhasil");
            exit;
        } else {
            echo "Gagal mengubah data siswa: " . mysqli_error($koneksi);
        }
    }
} else {
    header("Location: index.php?page=siswa");
    exit;
}
