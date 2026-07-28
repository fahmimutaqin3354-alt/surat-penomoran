<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Arsip Surat | PT Microdata Indonesia</title>

    <!-- Google Fonts & Bootstrap Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CDN Tailwind CSS (Dapat diganti dengan Vite / Tailwind CLI) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            dark: '#080a16',
                            card: 'rgba(13, 17, 38, 0.75)',
                            purple: '#6366f1',
                            pink: '#ec4899',
                        }
                    },
                    animation: {
                        'float': 'float 5s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out infinite 1s',
                        'float-slow': 'float 7s ease-in-out infinite 0.5s',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-12px) rotate(0.5deg)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Blend Mode & Glowing Effects */
        .logo-blend {
            mix-blend-mode: screen;
            filter: brightness(115%) contrast(125%);
        }
        
        /* Custom Glassmorphism Border & Backdrops */
        .glass-card {
            background-color: rgba(13, 17, 38, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-nav {
            background-color: rgba(8, 10, 22, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-badge {
            background-color: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gradient-text {
            background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gradient-btn {
            background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%);
        }
    </style>
</head>
<body class="bg-[#080a16] text-slate-100 font-sans antialiased selection:bg-pink-500 selection:text-white relative min-h-screen overflow-x-hidden">

    <!-- Dynamic Background Ambient Lighting -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-1/4 left-10 w-[400px] h-[400px] bg-indigo-600/15 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 right-10 w-[450px] h-[450px] bg-pink-500/12 rounded-full blur-[140px]"></div>
    </div>

    <!-- Navigation Header -->
    <header class="fixed top-0 inset-x-0 z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="#" class="flex items-center group">
                    <div class="relative flex items-center justify-center">
                        <img src="{{ asset('images/microdata-logo.webp') }}" 
                             alt="Logo PT Microdata Indonesia" 
                             class="h-16 md:h-20 max-h-20 w-auto object-contain logo-blend transition-transform duration-300 group-hover:scale-105">
                    </div>
                </a>

                <!-- Navigation Actions -->
                <div class="flex items-center space-x-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white gradient-btn shadow-lg shadow-pink-500/20 hover:shadow-pink-500/35 hover:-translate-y-0.5 transition-all">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-slate-200 glass-badge hover:bg-white/10 border border-white/10 hover:border-white/20 hover:-translate-y-0.5 transition-all">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white gradient-btn shadow-lg shadow-pink-500/20 hover:shadow-pink-500/35 hover:-translate-y-0.5 transition-all">
                            Daftar Akun
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Wrapper -->
    <main class="relative z-10">

        <!-- Hero Section -->
        <section class="pt-36 pb-20 lg:pt-44 lg:pb-28">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                    
                    <!-- Hero Content Left -->
                    <div class="lg:col-span-6 space-y-6 text-center lg:text-left">
                        <div>
                            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold tracking-wide text-slate-200 glass-badge mb-6">
                                <i class="bi bi-shield-check text-amber-400 text-sm"></i>
                                Sistem Administrasi Digital V2.0
                            </span>
                            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-[1.15]">
                                Kelola <span class="gradient-text">Arsip Surat</span> Perusahaan Lebih Efisien
                            </h1>
                        </div>
                        
                        <p class="text-lg text-slate-400 font-normal leading-relaxed max-w-xl mx-auto lg:mx-0">
                            Solusi terpusat untuk pengelolaan surat masuk, surat keluar, dan penomoran otomatis secara terstruktur, aman, dan mudah diakses.
                        </p>

                        @guest
                        <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-4">
                            <a href="{{ route('login') }}" 
                               class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl font-semibold text-white gradient-btn shadow-xl shadow-pink-500/25 hover:shadow-pink-500/40 hover:-translate-y-0.5 transition-all">
                                <span>Akses Sistem</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                            <a href="#fitur" 
                               class="inline-flex items-center px-7 py-3.5 rounded-xl font-semibold text-white glass-badge hover:bg-white/10 hover:-translate-y-0.5 transition-all">
                                Pelajari Fitur
                            </a>
                        </div>
                        @endguest
                    </div>

                    <!-- Hero Visual Right (Mockup UI Dashboard) -->
                    <div class="lg:col-span-6 relative">
                        <div class="relative mx-auto max-w-lg lg:max-w-none">
                            <!-- Background Radial Glows -->
                            <div class="absolute -top-10 -right-10 w-64 h-64 bg-indigo-600/30 rounded-full blur-3xl pointer-events-none"></div>
                            <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-pink-500/25 rounded-full blur-3xl pointer-events-none"></div>

                            <!-- Interactive Dashboard Card -->
                            <div class="glass-card rounded-3xl p-6 shadow-2xl shadow-black/80 animate-float relative z-10">
                                
                                <!-- Card Header Bar -->
                                <div class="flex items-center justify-between pb-4 mb-5 border-b border-white/10">
                                    <div class="flex items-center space-x-1.5">
                                        <span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span>
                                        <span class="w-3 h-3 rounded-full bg-amber-500 inline-block"></span>
                                        <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                                    </div>
                                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 text-xs text-slate-400 w-2/3">
                                        <i class="bi bi-search"></i>
                                        <span class="truncate">Cari nomor / perihal / pengirim...</span>
                                    </div>
                                </div>

                                <!-- Mini Stats -->
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div class="p-3.5 rounded-2xl border border-white/10 bg-gradient-to-br from-indigo-500/20 to-purple-500/10">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-white text-base">
                                                <i class="bi bi-inbox-fill"></i>
                                            </div>
                                            <div>
                                                <span class="block text-[11px] font-medium text-slate-400">Surat Masuk</span>
                                                <span class="block text-sm font-bold text-white">842 Dokumen</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3.5 rounded-2xl border border-white/10 bg-gradient-to-br from-pink-500/20 to-rose-500/10">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-white text-base">
                                                <i class="bi bi-send-fill"></i>
                                            </div>
                                            <div>
                                                <span class="block text-[11px] font-medium text-slate-400">Surat Keluar</span>
                                                <span class="block text-sm font-bold text-white">438 Dokumen</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Document List Items -->
                                <div class="space-y-3">
                                    <!-- Item 1 -->
                                    <div class="p-3 rounded-2xl bg-white/[0.03] border border-white/10 flex items-center gap-3.5 hover:bg-white/[0.08] hover:translate-x-1 transition-all">
                                        <div class="w-11 h-11 rounded-xl bg-pink-500/15 border border-pink-500/30 flex items-center justify-center text-pink-400 text-xl shrink-0">
                                            <i class="bi bi-file-earmark-pdf-fill"></i>
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            <div class="flex items-center justify-between gap-2">
                                                <span class="text-[11px] font-semibold text-purple-400 tracking-wider">042/MD-SM/III/2026</span>
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 flex items-center gap-1">
                                                    <i class="bi bi-check-circle-fill"></i> Terarsip
                                                </span>
                                            </div>
                                            <h4 class="text-xs font-semibold text-slate-100 truncate mt-0.5">Surat Kerjasama IT Infrastructure</h4>
                                            <p class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1">
                                                <i class="bi bi-building"></i> PT Telecom Nusantara • Hari Ini
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Item 2 -->
                                    <div class="p-3 rounded-2xl bg-white/[0.03] border border-white/10 flex items-center gap-3.5 hover:bg-white/[0.08] hover:translate-x-1 transition-all">
                                        <div class="w-11 h-11 rounded-xl bg-indigo-500/15 border border-indigo-500/30 flex items-center justify-center text-indigo-400 text-xl shrink-0">
                                            <i class="bi bi-file-earmark-text-fill"></i>
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            <div class="flex items-center justify-between gap-2">
                                                <span class="text-[11px] font-semibold text-purple-400 tracking-wider">118/MD-SK/III/2026</span>
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-indigo-500/15 border border-indigo-500/30 text-indigo-400 flex items-center gap-1">
                                                    <i class="bi bi-gear-wide-connected"></i> Otomatis
                                                </span>
                                            </div>
                                            <h4 class="text-xs font-semibold text-slate-100 truncate mt-0.5">Penawaran Lisensi & Software Dev</h4>
                                            <p class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1">
                                                <i class="bi bi-person-check"></i> Disetujui Direksi • Kemarin
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Floating Badges -->
                            <!-- Top Right -->
                            <div class="absolute -top-4 -right-4 glass-card p-3 rounded-2xl shadow-xl flex items-center gap-3 z-20 animate-float-delayed hidden sm:flex">
                                <div class="w-9 h-9 rounded-xl bg-amber-400 flex items-center justify-center text-slate-900 font-bold text-base">
                                    <i class="bi bi-lightning-charge-fill"></i>
                                </div>
                                <div>
                                    <span class="block text-xs font-bold text-white">Penomoran Otomatis</span>
                                    <span class="block text-[10px] text-slate-400">Format Standar Perusahaan</span>
                                </div>
                            </div>

                            <!-- Bottom Left -->
                            <div class="absolute -bottom-5 -left-5 glass-card p-3 rounded-2xl shadow-xl flex items-center gap-3 z-20 animate-float-slow hidden sm:flex">
                                <div class="w-9 h-9 rounded-xl bg-emerald-500 flex items-center justify-center text-white text-base">
                                    <i class="bi bi-shield-lock-fill"></i>
                                </div>
                                <div>
                                    <span class="block text-xs font-bold text-white">Arsip Terenkripsi</span>
                                    <span class="block text-[10px] text-slate-400">Akses Terkontrol & Aman</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="fitur" class="py-20 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Title -->
                <div class="text-center max-w-xl mx-auto mb-16">
                    <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-semibold text-slate-200 glass-badge mb-3">
                        SOLUSI DIGITAL
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white tracking-tight mb-3">Fitur Utama Sistem</h2>
                    <p class="text-slate-400 text-sm sm:text-base">Sistem terpadu untuk efisiensi administrasi operasional PT Microdata Indonesia.</p>
                </div>

                <!-- Features Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Card 1 -->
                    <div class="group relative glass-card p-8 rounded-3xl transition-all duration-300 hover:-translate-y-2 hover:border-white/20 hover:shadow-2xl hover:shadow-indigo-500/10 overflow-hidden">
                        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-pink-500 text-2xl mb-6 transition-transform duration-300 group-hover:scale-110 group-hover:bg-gradient-to-br group-hover:from-indigo-500 group-hover:to-pink-500 group-hover:text-white">
                            <i class="bi bi-inbox-fill"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Surat Masuk</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">Pencatatan, pengkategorian, dan pencarian dokumen masuk dengan cepat.</p>
                    </div>

                    <!-- Card 2 -->
                    <div class="group relative glass-card p-8 rounded-3xl transition-all duration-300 hover:-translate-y-2 hover:border-white/20 hover:shadow-2xl hover:shadow-indigo-500/10 overflow-hidden">
                        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-pink-500 text-2xl mb-6 transition-transform duration-300 group-hover:scale-110 group-hover:bg-gradient-to-br group-hover:from-indigo-500 group-hover:to-pink-500 group-hover:text-white">
                            <i class="bi bi-send-fill"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Surat Keluar</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">Pembuatan, alur verifikasi, dan distribusi surat keluar internal/eksternal.</p>
                    </div>

                    <!-- Card 3 -->
                    <div class="group relative glass-card p-8 rounded-3xl transition-all duration-300 hover:-translate-y-2 hover:border-white/20 hover:shadow-2xl hover:shadow-indigo-500/10 overflow-hidden">
                        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-pink-500 text-2xl mb-6 transition-transform duration-300 group-hover:scale-110 group-hover:bg-gradient-to-br group-hover:from-indigo-500 group-hover:to-pink-500 group-hover:text-white">
                            <i class="bi bi-folder-symlink-fill"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Arsip Digital</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">Penyimpanan dokumen terpusat yang aman dengan dukungan pencarian pintar.</p>
                    </div>

                    <!-- Card 4 -->
                    <div class="group relative glass-card p-8 rounded-3xl transition-all duration-300 hover:-translate-y-2 hover:border-white/20 hover:shadow-2xl hover:shadow-indigo-500/10 overflow-hidden">
                        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-pink-500 text-2xl mb-6 transition-transform duration-300 group-hover:scale-110 group-hover:bg-gradient-to-br group-hover:from-indigo-500 group-hover:to-pink-500 group-hover:text-white">
                            <i class="bi bi-hash"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Nomor Otomatis</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">Penomoran surat otomatis yang mencegah bentrok dan sesuai format resmi.</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="py-12 mb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="glass-card rounded-3xl p-8 sm:p-12">
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="shrink-0">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-white/5 border border-white/10 flex items-center justify-center text-pink-500 text-4xl sm:text-5xl shadow-inner">
                                <i class="bi bi-building-gear"></i>
                            </div>
                        </div>
                        <div class="text-center md:text-left space-y-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-slate-200 glass-badge">
                                TENTANG SISTEM
                            </span>
                            <h3 class="text-2xl sm:text-3xl font-bold text-white">Optimalisasi Tata Kelola Arsip</h3>
                            <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                                Sistem Arsip Surat PT Microdata Indonesia memodernisasi administrasi kantor menjadi berbasis digital. Dengan integrasi terpusat, tim dapat memangkas waktu pencarian fisik, meminimalisir duplikasi nomor surat, dan menyajikan laporan arsip secara <span class="italic text-slate-300">real-time</span>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-[#05070f]/95 border-t border-white/10 py-12 text-center text-slate-400 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            <h4 class="text-white font-bold text-lg">PT Microdata Indonesia</h4>
            <p class="text-xs sm:text-sm text-slate-400">Sistem Pengelolaan Arsip Surat Masuk & Keluar Digital</p>
            <div class="w-24 h-px bg-white/10 mx-auto my-6"></div>
            <p class="text-xs text-slate-400">
                &copy; {{ date('Y') }} PT Microdata Indonesia. All Rights Reserved.
            </p>
        </div>
    </footer>

</body>
</html>