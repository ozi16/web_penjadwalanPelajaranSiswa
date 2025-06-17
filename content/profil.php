<?php

$id_user = $_SESSION['id']; // dari session login siswa

$query = mysqli_query($koneksi, "
    SELECT u.nama, u.nis, k.nama_kelas, s.jenis_kelamin, s.tanggal_lahir
    FROM users u
    LEFT JOIN kelas k ON u.id_kelas = k.id
    LEFT JOIN siswa s ON u.id = s.user_id
    WHERE u.id = '$id_user' AND u.id_level = 2
");

$data = mysqli_fetch_assoc($query);
?>

<section class="vh-100" style="background-color: #f4f5f7;">
    <div class="container ">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-6 mb-4 mb-lg-0">
                <div class="card mb-3" style="border-radius: .5rem;">
                    <div class="row g-0">
                        <div class="col-md-4 gradient-custom text-center text-white"
                            style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                            <i class="far fa-edit mb-5"></i>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h6>Information</h6>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                    <div class="col-6 mb-3">
                                        <h6>Name</h6>
                                        <p class="text-muted"><?= $data['nama'] ?></p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h6>NIS</h6>
                                        <p class="text-muted"><?= $data['nis'] ?></p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h6>Kelas</h6>
                                        <p class="text-muted"><?= $data['nama_kelas'] ?></p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h6>Jenis Kelamin</h6>
                                        <p class="text-muted"><?= $data['jenis_kelamin'] ?></p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h6>Tanggal Lahir</h6>
                                        <p class="text-muted"><?= $data['tanggal_lahir'] ?></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>