<?php
include 'koneksi.php';

// Delete data
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Hapus user berdasarkan ID
    $query = mysqli_query($koneksi, "DELETE FROM guru WHERE id = $id");

    if ($query) {
        header("Location: index.php?page=guru&hapus=success");
        exit;
    } else {
        echo "Gagal menghapus data guru: " . mysqli_error($koneksi);
    }
}


// Cek apakah form disubmit
if (isset($_POST['add']) || isset($_POST['edit'])) {
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama_guru = mysqli_real_escape_string($koneksi, $_POST['nama_guru']);



    if (isset($_POST['add'])) {
        $query = mysqli_query($koneksi, "INSERT INTO guru (nip, nama_guru) 
        VALUES ('$nip', '$nama_guru')");

        if ($query) {
            header("Location: index.php?page=guru&tambah=success");
            exit;
        } else {
            echo "Gagal menambahkan data guru: " . mysqli_error($koneksi);
        }
    }

    if (isset($_POST['edit'])) {
        $id = intval($_POST['id']);

        $query = mysqli_query($koneksi, "UPDATE guru SET 
            nip = '$nip',
            nama_guru = '$nama_guru'
            WHERE id = $id");

        if ($query) {
            header("Location: index.php?page=guru&status=edit_berhasil");
            exit;
        } else {
            echo "Gagal mengubah data guru: " . mysqli_error($koneksi);
        }
    }
} else {
    header("Location: index.php?page=guru");
    exit;
}
