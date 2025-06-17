<?php
include 'koneksi.php';

// Delete data
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Hapus user berdasarkan ID
    $query = mysqli_query($koneksi, "DELETE FROM users WHERE id = $id");

    if ($query) {
        header("Location: index.php?page=siswa&hapus=success");
        exit;
    } else {
        echo "Gagal menghapus data siswa: " . mysqli_error($koneksi);
    }
}

// Cek apakah form disubmit
if (isset($_POST['add']) || isset($_POST['edit'])) {
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $id_kelas = intval($_POST['id_kelas']);
    $id_jurusan = intval($_POST['id_jurusan']);
    $id_level = 2; // siswa

    // Ambil data tambahan dari form
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $tanggal_lahir = mysqli_real_escape_string($koneksi, $_POST['tanggal_lahir']);

    // Untuk default password (misal: nis)
    $default_password = password_hash($nis, PASSWORD_DEFAULT);

    if (isset($_POST['add'])) {
        // Masukkan ke tabel users
        $query = mysqli_query($koneksi, "INSERT INTO users (nis, nama, password, id_kelas, id_jurusan, id_level) 
        VALUES ('$nis', '$nama', '$default_password', $id_kelas, $id_jurusan, $id_level)");

        if ($query) {
            // Ambil ID user yang baru ditambahkan
            $user_id = mysqli_insert_id($koneksi);

            // Masukkan data tambahan ke tabel siswa
            $query_siswa = mysqli_query($koneksi, "INSERT INTO siswa (user_id, jenis_kelamin, tanggal_lahir) 
                VALUES ($user_id, '$jenis_kelamin', '$tanggal_lahir')");

            if (!$query_siswa) {
                echo "Gagal menambahkan data ke tabel siswa: " . mysqli_error($koneksi);
            }

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
            // Update data tambahan di tabel siswa
            $query_update_siswa = mysqli_query($koneksi, "UPDATE siswa SET 
                jenis_kelamin = '$jenis_kelamin',
                tanggal_lahir = '$tanggal_lahir'
                WHERE user_id = $id");

            if (!$query_update_siswa) {
                echo "Gagal mengubah data siswa tambahan: " . mysqli_error($koneksi);
            }

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
