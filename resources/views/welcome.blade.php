<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Arsip Surat | PT Microdata Indonesia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f7fc;
            font-family:Arial, Helvetica, sans-serif;
        }

        .navbar{
            background:#0d47a1;
        }

        .hero{
            padding:90px 0;
            background:linear-gradient(135deg,#0d47a1,#1976d2);
            color:white;
        }

        .hero img{
            width:320px;
        }

        .feature-card{
            background:white;
            border-radius:15px;
            box-shadow:0 5px 15px rgba(0,0,0,.1);
            padding:30px;
            transition:.3s;
            height:100%;
        }

        .feature-card:hover{
            transform:translateY(-5px);
        }

        .icon{
            font-size:50px;
        }

        footer{
            background:#0d47a1;
            color:white;
            padding:20px;
            margin-top:60px;
        }
    </style>

</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container">

        <a class="navbar-brand fw-bold" href="#">
            PT MICRODATA INDONESIA
        </a>

        <div>

            @auth

                <a href="{{ url('/dashboard') }}" class="btn btn-warning">
                    Dashboard
                </a>

            @else

                <a href="{{ route('login') }}" class="btn btn-light me-2">
                    Login
                </a>

                <a href="{{ route('register') }}" class="btn btn-warning">
                    Register
                </a>

            @endauth

        </div>

    </div>

</nav>

<!-- Hero -->
<section class="hero">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-md-6">

                <h1 class="display-5 fw-bold">
                    SISTEM ARSIP SURAT
                </h1>

                <h3>PT MICRODATA INDONESIA</h3>

                <p class="mt-4">

                    Sistem ini digunakan untuk mengelola surat masuk,
                    surat keluar, arsip digital serta penomoran surat
                    secara otomatis sehingga proses administrasi menjadi
                    lebih cepat, rapi dan aman.

                </p>

                @guest

                <a href="{{ route('login') }}" class="btn btn-warning btn-lg mt-3">
                    Masuk Sekarang
                </a>

                @endguest

            </div>

            <div class="col-md-6 text-center">

                <img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png" class="img-fluid">

            </div>

        </div>

    </div>

</section>

<!-- Fitur -->
<div class="container py-5">

    <h2 class="text-center mb-5 fw-bold">
        Fitur Sistem
    </h2>

    <div class="row g-4">

        <div class="col-md-3">

            <div class="feature-card text-center">

                <div class="icon">📥</div>

                <h4>Surat Masuk</h4>

                <p>
                    Mengelola data surat masuk perusahaan.
                </p>

            </div>

        </div>

        <div class="col-md-3">

            <div class="feature-card text-center">

                <div class="icon">📤</div>

                <h4>Surat Keluar</h4>

                <p>
                    Membuat dan menyimpan surat keluar.
                </p>

            </div>

        </div>

        <div class="col-md-3">

            <div class="feature-card text-center">

                <div class="icon">📁</div>

                <h4>Arsip Digital</h4>

                <p>
                    Menyimpan dokumen secara aman dan mudah dicari.
                </p>

            </div>

        </div>

        <div class="col-md-3">

            <div class="feature-card text-center">

                <div class="icon">🔢</div>

                <h4>Nomor Otomatis</h4>

                <p>
                    Penomoran surat otomatis sesuai format perusahaan.
                </p>

            </div>

        </div>

    </div>

</div>

<!-- Tentang -->
<div class="container mb-5">

    <div class="card shadow border-0">

        <div class="card-body p-5">

            <h2 class="text-center mb-4">
                Tentang Sistem
            </h2>

            <p class="text-center">

                Sistem Arsip Surat PT Microdata Indonesia dibuat untuk
                mempermudah proses pengelolaan surat masuk dan surat keluar.
                Seluruh data surat tersimpan secara digital sehingga
                memudahkan pencarian arsip, pencetakan laporan,
                serta penomoran surat yang lebih teratur.

            </p>

        </div>

    </div>

</div>

<!-- Footer -->
<footer class="text-center">

    <h5>PT Microdata Indonesia</h5>

    <p>Sistem Arsip Surat Masuk & Surat Keluar</p>

    <small>
        © {{ date('Y') }} PT Microdata Indonesia. All Rights Reserved.
    </small>

</footer>

</body>
</html>
