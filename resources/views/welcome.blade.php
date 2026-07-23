<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Arsip Surat</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{
            background:#f5f7fb;
            font-family: 'Segoe UI',sans-serif;
        }

        .navbar{
            background:#0d6efd;
        }

        .hero{
            min-height:90vh;
            display:flex;
            align-items:center;
        }

        .hero h1{
            font-size:3rem;
            font-weight:bold;
            color:#1e293b;
        }

        .hero p{
            color:#64748b;
            font-size:18px;
        }

        .btn-login{
            background:#0d6efd;
            color:white;
            padding:12px 30px;
            border-radius:10px;
        }

        .btn-login:hover{
            background:#0b5ed7;
            color:white;
        }

        .card-feature{
            border:none;
            border-radius:20px;
            transition:.3s;
            box-shadow:0 10px 25px rgba(0,0,0,.08);
        }

        .card-feature:hover{
            transform:translateY(-8px);
        }

        .icon-box{
            width:70px;
            height:70px;
            background:#e8f1ff;
            border-radius:50%;
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:30px;
            color:#0d6efd;
            margin:auto;
        }

        footer{
            background:white;
            padding:20px;
            text-align:center;
            color:#6c757d;
            margin-top:60px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow">
    <div class="container">

        <a class="navbar-brand fw-bold" href="#">
            <i class="bi bi-envelope-paper-fill"></i>
            Sistem Arsip Surat
        </a>

        <div>

            @auth

                <a href="{{ url('/dashboard') }}" class="btn btn-light">
                    Dashboard
                </a>

            @else

                <a href="{{ route('login') }}" class="btn btn-light">
                    Login
                </a>

            @endauth

        </div>

    </div>
</nav>


<section class="hero">
    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6">

                <h1>
                    Sistem Arsip Surat Digital
                </h1>

                <p class="mt-4">
                    Kelola surat masuk dan surat keluar dengan lebih cepat,
                    aman, dan terorganisir menggunakan sistem berbasis web.
                </p>

                <div class="mt-4">

                    @auth

                        <a href="{{ url('/dashboard') }}" class="btn btn-login">
                            <i class="bi bi-speedometer2"></i>
                            Dashboard
                        </a>

                    @else

                        <a href="{{ route('login') }}" class="btn btn-login">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Login Admin
                        </a>

                    @endauth

                </div>

            </div>

            <div class="col-lg-6 text-center">

                <i class="bi bi-envelope-paper-fill"
                   style="font-size:250px;color:#0d6efd;"></i>

            </div>

        </div>

    </div>
</section>


<div class="container">

    <div class="row g-4">

        <div class="col-md-4">

            <div class="card card-feature p-4 text-center">

                <div class="icon-box">
                    <i class="bi bi-envelope-arrow-down"></i>
                </div>

                <h4 class="mt-4">
                    Surat Masuk
                </h4>

                <p class="text-muted">
                    Menyimpan seluruh data surat masuk secara digital.
                </p>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card card-feature p-4 text-center">

                <div class="icon-box">
                    <i class="bi bi-envelope-arrow-up"></i>
                </div>

                <h4 class="mt-4">
                    Surat Keluar
                </h4>

                <p class="text-muted">
                    Mengelola surat keluar dengan nomor surat otomatis.
                </p>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card card-feature p-4 text-center">

                <div class="icon-box">
                    <i class="bi bi-shield-check"></i>
                </div>

                <h4 class="mt-4">
                    Aman
                </h4>

                <p class="text-muted">
                    Arsip tersimpan dengan aman dan mudah dicari kembali.
                </p>

            </div>

        </div>

    </div>

</div>

<footer>

    © {{ date('Y') }} Sistem Arsip Surat | Laravel 12

</footer>

</body>
</html>
