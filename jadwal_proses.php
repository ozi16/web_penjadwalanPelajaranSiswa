<?php
include 'koneksi.php';

// Delete data
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Hapus jadwal berdasarkan ID
    $query = mysqli_query($koneksi, "DELETE FROM jadwal WHERE id = $id");

    if ($query) {
        header("Location: index.php?page=jadwal&hapus=success");
        exit;
    } else {
        echo "Gagal menghapus data jadwal: " . mysqli_error($koneksi);
    }
}

// Cek apakah form disubmit
if (isset($_POST['add']) || isset($_POST['edit'])) {
    $hari = mysqli_real_escape_string($koneksi, $_POST['hari']);
    $jam_mulai = mysqli_real_escape_string($koneksi, $_POST['jam_mulai']);
    $jam_selesai = mysqli_real_escape_string($koneksi, $_POST['jam_selesai']);
    $id_kelas = intval($_POST['id_kelas']);
    $id_guru = intval($_POST['id_guru']);
    $id_pelajaran = intval($_POST['id_pelajaran']);

    if (isset($_POST['add'])) {
        $query = mysqli_query($koneksi, "INSERT INTO jadwal (hari, jam_mulai, jam_selesai, id_kelas, id_guru, id_pelajaran) 
        VALUES ('$hari', '$jam_mulai', '$jam_selesai', $id_kelas, $id_guru, $id_pelajaran)");

        if ($query) {
            header("Location: index.php?page=jadwal&tambah=success");
            exit;
        } else {
            echo "Gagal menambahkan data jadwal: " . mysqli_error($koneksi);
        }
    }

    if (isset($_POST['edit'])) {
        $id = intval($_POST['id']);

        $query = mysqli_query($koneksi, "UPDATE jadwal SET 
            hari = '$hari',
            jam_mulai = '$jam_mulai',
            jam_selesai = '$jam_selesai',
            id_kelas = $id_kelas,
            id_guru = $id_guru,
            id_pelajaran = $id_pelajaran
            WHERE id = $id");

        if ($query) {
            header("Location: index.php?page=jadwal&status=edit_berhasil");
            exit;
        } else {
            echo "Gagal mengubah data jadwal: " . mysqli_error($koneksi);
        }
    }
} else {
    header("Location: index.php?page=jadwal");
    exit;
}
