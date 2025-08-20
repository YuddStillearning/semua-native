<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Pengelolaan Klinik Bunda Aliya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        .sidebar .nav-link {
            color: #000;
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar p-3">
            <h5 class="fw-bold">MENU</h5>
            <div class="mb-4">
                <strong>Form</strong>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link <?= ($_GET['page'] ?? '') == 'peserta' ? 'active' : '' ?>" href="?page=peserta">Data Peserta</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($_GET['page'] ?? '') == 'bidan' ? 'active' : '' ?>" href="?page=bidan">Data Bidan</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($_GET['page'] ?? '') == 'poli' ? 'active' : '' ?>" href="?page=poli">Data Poli</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($_GET['page'] ?? '') == 'rekam_medis' ? 'active' : '' ?>" href="?page=rekam_medis">Data Rekam Medis</a></li>
                </ul>
            </div>
            <div>
                <strong>Laporan</strong>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link <?= ($_GET['page'] ?? '') == 'list_bidan' ? 'active' : '' ?>" href="?page=list_bidan">List Bidan</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($_GET['page'] ?? '') == 'list_peserta' ? 'active' : '' ?>" href="?page=list_peserta">List Peserta</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($_GET['page'] ?? '') == 'list_rekam_medis' ? 'active' : '' ?>" href="?page=list_rekam_medis">List Data Rekam Medis</a></li>
                </ul>
            </div>
        </nav>

        <!-- Content -->
        <main class="col-md-9 col-lg-10 p-4">
            <?php
            $page = $_GET['page'] ?? 'home';
            $file = "pages/$page.php";
            if (file_exists($file)) {
                include $file;
            } else {
                echo "<h3>Selamat Datang di Aplikasi Pengelolaan Klinik Bunda Aliya</h3>";
                echo "<p>Pilih menu di sebelah kiri untuk mulai.</p>";
            }
            ?>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
