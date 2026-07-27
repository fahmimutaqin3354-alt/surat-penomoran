<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Arsip Surat | PT Microdata Indonesia</title>

    <!-- Google Fonts & Bootstrap Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-blue: #0f2b5c;
            --accent-blue: #2563eb;
            --accent-cyan: #06b6d4;
            --accent-purple: #8b5cf6;
            --light-bg: #f8fafc;
            --text-dark: #0f172a;
            --text-muted: #64748b;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Navbar Styling */
        .navbar {
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            color: var(--primary-blue) !important;
            letter-spacing: -0.5px;
        }

        .brand-icon {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-cyan));
            color: white;
            padding: 8px 10px;
            border-radius: 10px;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        /* Hero Section Styling */
        .hero {
            padding: 120px 0 90px;
            background: radial-gradient(circle at 10% 20%, #1e3a8a 0%, #0f172a 90%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.35) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }

        .hero-title {
            letter-spacing: -1.5px;
            line-height: 1.15;
            font-size: 3.2rem;
        }

        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #38bdf8 50%, #818cf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .badge-sub {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Hero Visual - Dashboard Preview Mockup */
        .hero-visual-wrapper {
            position: relative;
            padding: 10px;
            z-index: 1;
        }

        .glow-effect {
            position: absolute;
            border-radius: 50%;
            filter: blur(50px);
            opacity: 0.6;
            z-index: 0;
        }

        .glow-1 {
            width: 250px;
            height: 250px;
            background: #3b82f6;
            top: -20px;
            right: 20px;
        }

        .glow-2 {
            width: 220px;
            height: 220px;
            background: #8b5cf6;
            bottom: -20px;
            left: 20px;
        }

        .dashboard-preview-card {
            position: relative;
            z-index: 1;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 30px rgba(59, 130, 246, 0.2);
            animation: float 5s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(0.5deg); }
        }

        .card-header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 16px;
            margin-bottom: 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .window-dots {
            display: flex;
            gap: 6px;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .dot.red { background-color: #ef4444; }
        .dot.yellow { background-color: #f59e0b; }
        .dot.green { background-color: #10b981; }

        .mock-search-bar {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 0.8rem;
            color: #94a3b8;
            display: flex;
            align-items: center;
            width: 65%;
        }

        .mini-stat-box {
            border-radius: 14px;
            padding: 12px 14px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: left;
        }

        .bg-blue-gradient {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.3) 0%, rgba(30, 58, 138, 0.3) 100%);
        }

        .bg-purple-gradient {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.3) 0%, rgba(88, 28, 135, 0.3) 100%);
        }

        .stat-icon-bg {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            color: white;
        }

        .stat-label {
            font-size: 0.72rem;
            color: #94a3b8;
            display: block;
        }

        .stat-val {
            font-size: 0.95rem;
            font-weight: 700;
            color: white;
        }

        .doc-item-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 12px 16px;
            margin-top: 12px;
            display: flex;
            align-items: center;
            gap: 14px;
            text-align: left;
            transition: all 0.3s ease;
        }

        .doc-item-card:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }

        .doc-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .doc-icon.pdf {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .doc-icon.word {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .doc-code {
            font-size: 0.72rem;
            font-weight: 600;
            color: #38bdf8;
            letter-spacing: 0.5px;
        }

        .doc-title {
            font-size: 0.88rem;
            font-weight: 600;
            color: #f8fafc;
            margin: 2px 0 1px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 230px;
        }

        .doc-meta {
            font-size: 0.72rem;
            color: #94a3b8;
        }

        .status-badge {
            font-size: 0.68rem;
            padding: 3px 8px;
            border-radius: 20px;
            font-weight: 600;
        }

        .status-badge.success {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-badge.primary {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        /* Floating Overlay Badges */
        .floating-badge {
            position: absolute;
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 10px 16px;
            border-radius: 16px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 2;
        }

        .badge-top-right {
            top: -15px;
            right: -15px;
            animation: float 6s ease-in-out infinite 1s;
        }

        .badge-bottom-left {
            bottom: -20px;
            left: -20px;
            animation: float 7s ease-in-out infinite 0.5s;
        }

        .badge-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .badge-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: white;
            display: block;
        }

        .badge-sub-text {
            font-size: 0.7rem;
            color: #94a3b8;
            display: block;
        }

        /* Cards Styling */
        .feature-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            padding: 32px 24px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: transparent;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 30px -10px rgba(15, 23, 42, 0.08);
            border-color: #cbd5e1;
        }

        .card-1:hover::before { background: linear-gradient(90deg, #2563eb, #3b82f6); }
        .card-2:hover::before { background: linear-gradient(90deg, #10b981, #059669); }
        .card-3:hover::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
        .card-4:hover::before { background: linear-gradient(90deg, #06b6d4, #0891b2); }

        .icon-box {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 22px;
            transition: transform 0.3s ease;
        }

        .feature-card:hover .icon-box {
            transform: scale(1.08);
        }

        /* Custom Buttons */
        .btn-custom-primary {
            background: linear-gradient(135deg, var(--accent-blue) 0%, #1d4ed8 100%);
            color: white;
            border: none;
            font-weight: 600;
            border-radius: 12px;
            padding: 12px 28px;
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4);
            transition: all 0.3s ease;
        }

        .btn-custom-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(37, 99, 235, 0.5);
        }

        .btn-custom-outline {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(8px);
            font-weight: 600;
            border-radius: 12px;
            padding: 12px 26px;
            transition: all 0.3s ease;
        }

        .btn-custom-outline:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
        }

        /* About Section Card */
        .about-card {
            background: white;
            border-radius: 24px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.03);
        }

        .about-icon-wrapper {
            width: 100px;
            height: 100px;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-blue);
            font-size: 48px;
        }

        /* Footer */
        footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 50px 0 30px;
            margin-top: 90px;
            border-top: 1px solid #1e293b;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold fs-5 d-flex align-items-center gap-2" href="#">
            <span class="brand-icon"><i class="bi bi-box-seam-fill"></i></span>
            <span class="fw-extrabold">PT MICRODATA INDONESIA</span>
        </a>

        <div class="d-flex align-items-center gap-2">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-custom-primary btn-sm px-3">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-light border btn-sm px-3 fw-semibold text-secondary me-1">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="btn btn-custom-primary btn-sm px-3">
                    Daftar Akun
                </a>
            @endauth
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6">
                <span class="badge badge-sub rounded-pill px-3 py-2 text-white fw-medium mb-3 d-inline-flex align-items-center gap-2">
                    <i class="bi bi-shield-check text-warning fs-6"></i> Sistem Administrasi Digital V2.0
                </span>
                <h1 class="hero-title fw-extrabold text-white mb-3">
                    Kelola <span class="gradient-text">Arsip Surat</span> Perusahaan Lebih Efisien
                </h1>
                <p class="fs-5 text-white-50 fw-normal leading-relaxed mb-4">
                    Solusi terpusat untuk surat masuk, surat keluar, dan penomoran otomatis secara terstruktur, aman, dan dapat diakses kapan saja.
                </p>

                @guest
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('login') }}" class="btn btn-custom-primary btn-lg fs-6">
                        Akses Sistem <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                    <a href="#fitur" class="btn btn-custom-outline btn-lg fs-6">
                        Pelajari Fitur
                    </a>
                </div>
                @endguest
            </div>

            <!-- Modern Interactive UI Preview Mockup (Pengganti Gambar Logo Besar) -->
            <div class="col-lg-6">
                <div class="hero-visual-wrapper">
                    <div class="glow-effect glow-1"></div>
                    <div class="glow-effect glow-2"></div>

                    <div class="dashboard-preview-card">
                        <div class="card-header-bar">
                            <div class="window-dots">
                                <span class="dot red"></span>
                                <span class="dot yellow"></span>
                                <span class="dot green"></span>
                            </div>
                            <div class="mock-search-bar">
                                <i class="bi bi-search me-2"></i>
                                <span>Cari nomor / perihal / pengirim...</span>
                            </div>
                        </div>

                        <div class="card-body-content">
                            <!-- Mini Stat Widgets -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="mini-stat-box bg-blue-gradient">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="stat-icon-bg"><i class="bi bi-inbox-fill"></i></div>
                                            <div>
                                                <span class="stat-label">Surat Masuk</span>
                                                <h6 class="stat-val mb-0">842 Dokumen</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mini-stat-box bg-purple-gradient">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="stat-icon-bg"><i class="bi bi-send-fill"></i></div>
                                            <div>
                                                <span class="stat-label">Surat Keluar</span>
                                                <h6 class="stat-val mb-0">438 Dokumen</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Document Item Preview 1 -->
                            <div class="doc-item-card">
                                <div class="doc-icon pdf">
                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                </div>
                                <div class="doc-details flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="doc-code">042/MD-SM/III/2026</span>
                                        <span class="status-badge success"><i class="bi bi-check-circle-fill"></i> Terarsip</span>
                                    </div>
                                    <h6 class="doc-title">Surat Kerjasama IT Infrastructure</h6>
                                    <small class="doc-meta"><i class="bi bi-building"></i> PT Telecom Nusantara • Hari Ini</small>
                                </div>
                            </div>

                            <!-- Document Item Preview 2 -->
                            <div class="doc-item-card">
                                <div class="doc-icon word">
                                    <i class="bi bi-file-earmark-text-fill"></i>
                                </div>
                                <div class="doc-details flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="doc-code">118/MD-SK/III/2026</span>
                                        <span class="status-badge primary"><i class="bi bi-gear-wide-connected"></i> Otomatis</span>
                                    </div>
                                    <h6 class="doc-title">Penawaran Lisensi & Software Dev</h6>
                                    <small class="doc-meta"><i class="bi bi-person-check"></i> Disetujui Direksi • Kemarin</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge 1 -->
                    <div class="floating-badge badge-top-right">
                        <div class="badge-icon bg-warning text-dark"><i class="bi bi-lightning-charge-fill"></i></div>
                        <div>
                            <span class="badge-title">Penomoran Otomatis</span>
                            <span class="badge-sub-text">Format Standar Perusahaan</span>
                        </div>
                    </div>

                    <!-- Floating Badge 2 -->
                    <div class="floating-badge badge-bottom-left">
                        <div class="badge-icon bg-success text-white"><i class="bi bi-shield-lock-fill"></i></div>
                        <div>
                            <span class="badge-title">Arsip Terenkripsi</span>
                            <span class="badge-sub-text">Akses Terkontrol & Aman</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fitur Section -->
<section id="fitur" class="container py-5 my-4">
    <div class="text-center max-w-xl mx-auto mb-5">
        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-semibold mb-2">SOLUSI DIGITAL</span>
        <h2 class="fw-bold text-dark mb-2 fs-2">Fitur Utama Sistem</h2>
        <p class="text-secondary fs-6">Sistem terpadu untuk efisiensi administrasi operasional PT Microdata Indonesia.</p>
    </div>

    <div class="row g-4">
        <!-- Fitur 1 -->
        <div class="col-md-6 col-lg-3">
            <div class="feature-card card-1 text-center">
                <div class="icon-box bg-primary-subtle text-primary">
                    <i class="bi bi-inbox-fill"></i>
                </div>
                <h5 class="fw-bold mb-2">Surat Masuk</h5>
                <p class="text-secondary small mb-0">Pencatatan, pengkategorian, dan pencarian dokumen masuk dengan cepat.</p>
            </div>
        </div>

        <!-- Fitur 2 -->
        <div class="col-md-6 col-lg-3">
            <div class="feature-card card-2 text-center">
                <div class="icon-box bg-success-subtle text-success">
                    <i class="bi bi-send-fill"></i>
                </div>
                <h5 class="fw-bold mb-2">Surat Keluar</h5>
                <p class="text-secondary small mb-0">Pembuatan, alur verifikasi, dan distribusi surat keluar internal/eksternal.</p>
            </div>
        </div>

        <!-- Fitur 3 -->
        <div class="col-md-6 col-lg-3">
            <div class="feature-card card-3 text-center">
                <div class="icon-box bg-warning-subtle text-warning">
                    <i class="bi bi-folder-symlink-fill"></i>
                </div>
                <h5 class="fw-bold mb-2">Arsip Digital</h5>
                <p class="text-secondary small mb-0">Penyimpanan dokumen terpusat yang aman dengan dukungan pencarian pintar.</p>
            </div>
        </div>

        <!-- Fitur 4 -->
        <div class="col-md-6 col-lg-3">
            <div class="feature-card card-4 text-center">
                <div class="icon-box bg-info-subtle text-info">
                    <i class="bi bi-hash"></i>
                </div>
                <h5 class="fw-bold mb-2">Nomor Otomatis</h5>
                <p class="text-secondary small mb-0">Penomoran surat otomatis yang mencegah bentrok dan sesuai format resmi.</p>
            </div>
        </div>
    </div>
</section>

<!-- Tentang Section -->
<section class="container mb-5">
    <div class="about-card p-4 p-md-5">
        <div class="row align-items-center">
            <div class="col-md-3 text-center mb-4 mb-md-0">
                <div class="about-icon-wrapper">
                    <i class="bi bi-building-gear"></i>
                </div>
            </div>
            <div class="col-md-9">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 fw-semibold mb-2">TENTANG SISTEM</span>
                <h3 class="fw-bold mb-3">Optimalisasi Tata Kelola Arsip</h3>
                <p class="text-secondary leading-relaxed mb-0">
                    Sistem Arsip Surat PT Microdata Indonesia memodernisasi administrasi kantor menjadi berbasis digital. Dengan integrasi terpusat, tim dapat memangkas waktu pencarian fisik, meminimalisir duplikasi nomor surat, dan menyajikan laporan arsip secara *real-time*.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="text-center">
    <div class="container">
        <h6 class="text-white fw-bold mb-1">PT Microdata Indonesia</h6>
        <p class="small text-white-50 mb-3">Sistem Pengelolaan Arsip Surat Masuk & Keluar Digital</p>
        <hr class="border-secondary opacity-25 my-4">
        <small class="text-secondary">
            © {{ date('Y') }} PT Microdata Indonesia. All Rights Reserved.
        </small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
