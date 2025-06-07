<?php
session_start();
include 'koneksi.php';



if (isset($_POST['login'])) {
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE nis='$nis'");

    if (mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);

        // Gunakan password_verify jika password di-hash
        if (password_verify($password, $user['password'])) {
            $_SESSION['id']        = $user['id'];
            $_SESSION['nama']      = $user['nama'];
            $_SESSION['id_level']  = $user['id_level'];
            $_SESSION['id_kelas']  = $user['id_kelas'];

            header("Location: index.php");
            exit;
        } else {
            header("Location: login.php?login=gagal");
            exit;
        }
    } else {
        header("Location: login.php?login=gagal");

        exit;
    }
}
?>


<!DOCTYPE html>


<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="assets/assets"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login</title>

    <meta name="description" content="" />



    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="assets/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="assets/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="assets/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/assets/js/config.js"></script>

    <!-- Link Css -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<style>
    .logo-inside-card {
        width: 80px;
        height: 70px;
        object-fit: cover;
        border-radius: 50%;

    }

    /* Bikin gambar responsif */
    .animated-image {
        max-width: 100%;
        height: auto;
        animation: floatImage 4s ease-in-out infinite;
        border-radius: 10px;
    }

    /* Animasi logo berputar */
    @keyframes rotateLogo {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Animasi gambar naik turun */
    @keyframes floatImage {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    /* Responsive tambahan jika dibutuhkan */
    @media (max-width: 768px) {
        .logo-inside-card {
            width: 50px;
            height: 50px;
        }

        .signin-text {
            font-size: 20px;
        }
    }
</style>


<body>
    <div class="position-relative">

    </div>
    <div class="container shadow-sm">
        <!-- Tambahkan logo di dalam card -->
        <div class="text-start mb-3">
            <img src="assets/img/logocn.png" alt="Logo SMK Citra Negara" class="logo-inside-card">
            <h1 class="fw-bold pt-2 text-center text-white mb-4 ">
                Selamat Datang di Penjadwalan Siswa <br> RPL SMK Citra Negara
            </h1>
        </div>

        <!-- <h1 class="fw-bold pt-2 text-center text-white mb-4 ">
            Selamat Datang di Penjadwalan Siswa <br> RPL SMK Citra Negara
        </h1> -->

        <div class="row content mt-4">
            <div class="col-md-6 mb-3 text-center">
                <!-- Gambar yang ingin dibuat responsif dan animasi -->
                <img src="assets/img/logocn.png" class="img-fluid animated-image" alt="Gambar Login">
            </div>

            <div class="col-md-6">
                <h3 class="signin-text mb-3">Sign In</h3>
                <form method="post">
                    <div class="form-group">
                        <label for="email" class="text-black">Username</label>
                        <input type="text" name="nis" class="form-control">
                    </div>
                    <div class="form-group pt-1">
                        <label for="password" class="text-black">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <button class="btn btn-class" name="login" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>