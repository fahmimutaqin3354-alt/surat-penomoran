<!DOCTYPE html>
<html lang="id" class="dark">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - Sistem Arsip Surat</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            bg: '#020617',
                            card: '#0f172a',
                            border: '#1e293b'
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet"
href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css">
<link rel="stylesheet"
href="https://cdn.datatables.net/searchbuilder/1.8.2/css/searchBuilder.dataTables.css">

<link rel="stylesheet"
href="https://cdn.datatables.net/searchpanes/2.3.2/css/searchPanes.dataTables.css">
<style>

/* ============================
   DataTables Dark Modern
============================= */

.dataTables_wrapper{
    color:#e2e8f0;
    padding:20px;
}

/* Top */
.dataTables_length{
    float:left;
}

.dataTables_filter{
    float:right;
}

.dataTables_filter label,
.dataTables_length label{
    display:flex;
    align-items:center;
    gap:10px;
    color:#cbd5e1;
    font-weight:600;
}

/* Search */
.dataTables_filter input{
    width:260px;
    background:#111827 !important;
    color:white !important;
    border:1px solid #374151 !important;
    border-radius:8px;
    padding:8px 12px;
}

/* Dropdown */
.dataTables_length select{
    background:#111827;
    color:white;
    border:1px solid #374151;
    border-radius:8px;
    padding:6px 12px;
}

/* Table */
table.dataTable{
    border:none !important;
}

table.dataTable thead th{
    background:#1e293b !important;
    color:white !important;
    font-weight:700;
    border-bottom:1px solid #334155 !important;
    padding:18px;
}

table.dataTable tbody td{
    background:#0f172a;
    color:#e2e8f0;
    padding:18px;
    border-bottom:1px solid #1e293b;
}

table.dataTable tbody tr:hover{
    background:#1e293b !important;
}

/* Info */
.dataTables_info{
    color:#cbd5e1 !important;
    margin-top:18px;
}

/* Pagination */
.dataTables_paginate{
    margin-top:18px !important;
}

.dataTables_paginate .paginate_button{
    background:#1e293b !important;
    color:white !important;
    border-radius:8px !important;
    border:none !important;
    margin:0 4px;
    padding:6px 14px !important;
}

.dataTables_paginate .paginate_button.current{
    background:#4f46e5 !important;
}

.dataTables_paginate .paginate_button:hover{
    background:#6366f1 !important;
}

</style>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased selection:bg-indigo-500 selection:text-white min-h-screen">

    <!-- Top Navbar -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-slate-900/80 backdrop-blur-md border-b border-slate-800/80 z-40 flex items-center justify-between px-4 md:px-6">
        <div class="flex items-center gap-3">
            <!-- Sidebar Toggle Button (Mobile) -->
            <button id="toggleSidebar" aria-label="Toggle Navigation" class="md:hidden text-slate-400 hover:text-white p-2 rounded-lg hover:bg-slate-800/60 transition">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>

            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                <i class="fa-solid fa-box-archive text-indigo-500 text-xl"></i>
                <span class="font-bold text-lg tracking-tight text-white hidden sm:inline">Sistem Arsip Surat</span>
            </a>
        </div>

        <!-- User Profile Dropdown / Logout -->
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-3 bg-slate-800/50 border border-slate-700/50 px-3 py-1.5 rounded-full">
                <div class="w-7 h-7 rounded-full bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 flex items-center justify-center font-bold text-xs uppercase">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <span class="text-sm font-medium text-slate-200 hidden xs:inline">{{ Auth::user()->name ?? 'User' }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" title="Logout" class="text-slate-400 hover:text-rose-400 transition-colors ml-1 p-1">
                        <i class="fa-solid fa-right-from-bracket text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Overlay Backdrop for Mobile Sidebar -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-30 hidden md:hidden transition-opacity"></div>

    <!-- Sidebar Navigation -->
    <aside id="sidebar" class="fixed top-16 left-0 bottom-0 w-64 bg-slate-900/90 backdrop-blur-xl border-r border-slate-800/80 z-30 transition-transform -translate-x-full md:translate-x-0 overflow-y-auto">
        <div class="p-4 space-y-6">

            <!-- Brand Logo Inside Sidebar (Gantikan Logo 'M' Teks ke Gambar Logo Microdata) -->
            <div class="p-3.5 rounded-2xl bg-slate-950/80 border border-slate-800/80 backdrop-blur-xl flex items-center justify-center shadow-md">
                <img src="{{ asset('images/microdata-logo.webp') }}"
                     alt="Microdata Indonesia"
                     class="h-9 w-auto object-contain">
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1">

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Data Instansi (MENU BARU) -->
                <a href="{{ route('instansi.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('instansi.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-building w-5 text-center"></i>
                    <span>Data Instansi</span>
                </a>

                <!-- Surat Masuk -->
                <a href="{{ route('surat_masuk.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('surat_masuk.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-inbox w-5 text-center"></i>
                    <span>Surat Masuk</span>
                </a>

                <!-- Surat Keluar -->
                <a href="{{ route('surat_keluar.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('surat_keluar.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-paper-plane w-5 text-center"></i>
                    <span>Surat Keluar</span>
                </a>

                <!-- Arsip Surat -->
                <a href="{{ route('arsip.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:text-slate-100 hover:bg-slate-800/50 transition-all">
                    <i class="fa-solid fa-box-archive w-5 text-center"></i>
                    <span>Arsip Surat</span>
                </a>


                <!-- Laporan -->
                <a href="{{ route('laporan.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:text-slate-100 hover:bg-slate-800/50 transition-all">
                <i class="fa-solid fa-chart-column w-5 text-center"></i>
                <span>Laporan</span>
            </a>

            <!-- Pengaturan Akun -->
            <a href="{{ route('akun.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:text-slate-100 hover:bg-slate-800/50 transition-all">
                <i class="fa-solid fa-users w-5 text-center"></i>
                <span>Pengaturan Akun</span>
            </a>

             <!-- Recycle Bin -->
                <a href="{{ route('recycle-bin.index') }}"
                class="flex items-center gap-4 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:text-slate-100 hover:bg-slate-800/50 transition-all">
                     <i class="fa-solid fa-trash-can"></i>
                  Tempat Sampah
                </a>

            </nav>
        </div>
    </aside>



    <!-- Main Content Container -->
    <main class="pt-20 pb-10 md:pl-64 transition-all">
        <div class="px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <!-- Mobile Sidebar Backdrop & Toggle Script -->
    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebarBackdrop');

        function toggleMenu() {
            if (sidebar && backdrop) {
                sidebar.classList.toggle('-translate-x-full');
                backdrop.classList.toggle('hidden');
            }
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', toggleMenu);
        }

        if (backdrop) {
            backdrop.addEventListener('click', toggleMenu);
        }
    </script>

    <!-- Flash Alert Handler (SweetAlert2) -->
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                background: '#0f172a',
                color: '#f8fafc',
                confirmButtonColor: '#6366f1'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                background: '#0f172a',
                color: '#f8fafc',
                confirmButtonColor: '#6366f1'
            });
        @endif
    </script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/searchbuilder/1.8.2/js/dataTables.searchBuilder.js"></script>

<script src="https://cdn.datatables.net/searchpanes/2.3.2/js/dataTables.searchPanes.js"></script>
    @stack('scripts')


</body>
</html>
