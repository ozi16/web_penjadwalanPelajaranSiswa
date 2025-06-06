<?php
include 'koneksi.php';

// Delete data
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Hapus user berdasarkan ID
    $query = mysqli_query($koneksi, "DELETE FROM kelas WHERE id = $id");

    if ($query) {
        header("Location: index.php?page=kelas&hapus=success");
        exit;
    } else {
        echo "Gagal menghapus data kelas: " . mysqli_error($koneksi);
    }
}


// Cek apakah form disubmit
if (isset($_POST['add']) || isset($_POST['edit'])) {
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama_kelas = mysqli_real_escape_string($koneksi, $_POST['nama_kelas']);



    if (isset($_POST['add'])) {
        $query = mysqli_query($koneksi, "INSERT INTO kelas (nama_kelas) 
        VALUES ('$nama_kelas')");

        if ($query) {
            header("Location: index.php?page=kelas&tambah=success");
            exit;
        } else {
            echo "Gagal menambahkan data kelas: " . mysqli_error($koneksi);
        }
    }

    if (isset($_POST['edit'])) {
        $id = intval($_POST['id']);

        $query = mysqli_query($koneksi, "UPDATE kelas SET 
            nama_kelas = '$nama_kelas'
            WHERE id = $id");

        if ($query) {
            header("Location: index.php?page=kelas&status=edit_berhasil");
            exit;
        } else {
            echo "Gagal mengubah data kelas: " . mysqli_error($koneksi);
        }
    }
} else {
    header("Location: index.php?page=kelas");
    exit;
}
