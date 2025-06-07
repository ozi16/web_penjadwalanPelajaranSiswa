<?php
session_start();
require 'koneksi.php'; // pastikan koneksi DB tersedia

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];
$password_lama = $_POST['password_lama'];
$password_baru = $_POST['password_baru'];
$konfirmasi_password = $_POST['konfirmasi_password'];

// ambil password lama dari DB
$stmt = $koneksi->prepare("SELECT password FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($password_db);
$stmt->fetch();
$stmt->close();

if (!password_verify($password_lama, $password_db)) {
    header("Location: index.php?page=gantiPassword&msg=Password%20lama%20salah");
    exit;
}

if ($password_baru !== $konfirmasi_password) {
    header("Location: index.php?page=gantiPassword&msg=Konfirmasi%20tidak%20sesuai");
    exit;
}

// hash dan update password
$password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
$update = $koneksi->prepare("UPDATE users SET password = ? WHERE id = ?");
$update->bind_param("si", $password_hash, $id);
$update->execute();

header("Location: index.php?page=gantiPassword&msg=Password%20berhasil%20diganti");
exit;
