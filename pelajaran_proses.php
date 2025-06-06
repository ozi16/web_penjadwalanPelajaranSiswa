<?php
include 'koneksi.php';

// Delete data
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Hapus pelajaran berdasarkan ID
    $query = mysqli_query($koneksi, "DELETE FROM pelajaran WHERE id = $id");

    if ($query) {
        header("Location: index.php?page=pelajaran&hapus=success");
        exit;
    } else {
        echo "Gagal menghapus data pelajaran: " . mysqli_error($koneksi);
    }
}

// Cek apakah form disubmit
if (isset($_POST['add']) || isset($_POST['edit'])) {
    $nama_pelajaran = mysqli_real_escape_string($koneksi, $_POST['nama_pelajaran']);
    $id_kategori = intval($_POST['id_kategori']);

    if (isset($_POST['add'])) {
        $query = mysqli_query($koneksi, "INSERT INTO pelajaran (nama_pelajaran, id_kategori) 
        VALUES ('$nama_pelajaran', $id_kategori)");

        if ($query) {
            header("Location: index.php?page=pelajaran&tambah=success");
            exit;
        } else {
            echo "Gagal menambahkan data pelajaran: " . mysqli_error($koneksi);
        }
    }

    if (isset($_POST['edit'])) {
        $id = intval($_POST['id']);

        $query = mysqli_query($koneksi, "UPDATE pelajaran SET 
            nama_pelajaran = '$nama_pelajaran',
            id_kategori = $id_kategori
            WHERE id = $id");


        if ($query) {
            header("Location: index.php?page=pelajaran&status=edit_berhasil");
            exit;
        } else {
            echo "Gagal mengubah data pelajaran: " . mysqli_error($koneksi);
        }
    }
} else {
    header("Location: index.php?page=pelajaran");
    exit;
}
