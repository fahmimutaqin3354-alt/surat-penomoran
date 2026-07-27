<aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform bg-slate-950/95 border-r border-slate-800/80 backdrop-blur-xl flex flex-col justify-between p-4 shadow-2xl">
    <div class="space-y-6">
        
        <!-- Header Logo Microdata Indonesia (Sesuai Foto Kedua) -->
        <div class="p-3.5 rounded-2xl bg-slate-900/80 border border-slate-800/90 shadow-inner">
            <div class="flex items-center gap-3">
                
                <!-- Icon Hexagon Oranye-Putih Microdata (SVG Precision) -->
                <div class="relative w-9 h-9 shrink-0 flex items-center justify-center">
                    <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-md">
                        <!-- Frame Hexagon Putih -->
                        <polygon points="50,5 90,26 90,74 50,95 10,74 10,26" fill="none" stroke="#ffffff" stroke-width="10" stroke-linejoin="round"/>
                        <!-- Topi Wisuda / Chevron Oranye -->
                        <path d="M 12 36 L 50 58 L 88 36 L 88 48 L 50 70 L 12 48 Z" fill="#f97316"/>
                    </svg>
                </div>

                <!-- Teks Microdata Indonesia -->
                <div class="flex flex-col justify-center overflow-hidden">
                    <span class="text-sm font-black tracking-widest text-white leading-none uppercase">
                        MICRODATA
                    </span>
                    <span class="text-[9px] font-extrabold tracking-wider text-orange-500 leading-none mt-1">
                        INDONESIA.CO.ID
                    </span>
                </div>

            </div>
            
            <!-- Subtitle/Sistem Tag -->
            <div class="mt-3 pt-2.5 border-t border-slate-800/80 text-center">
                <span class="text-[11px] font-medium text-slate-400 tracking-wide">
                    Sistem Arsip Surat
                </span>
            </div>
        </div>

        <hr class="border-slate-800/80 my-2">

        <!-- Menu Navigasi (Tailwind Styled) -->
        <nav class="space-y-1.5">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-indigo-600 text-white font-semibold text-sm shadow-lg shadow-indigo-600/30 transition">
                <i class="fa-solid fa-chart-pie text-base w-5 text-center"></i>
                <span>Dashboard</span>
            </a>

            <!-- Surat Masuk -->
            <a href="{{ route('surat_masuk.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900/80 font-medium text-sm transition">
                <i class="fa-solid fa-inbox text-base w-5 text-center"></i>
                <span>Surat Masuk</span>
            </a>

            <!-- Surat Keluar -->
            <a href="{{ route('surat_keluar.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900/80 font-medium text-sm transition">
                <i class="fa-solid fa-paper-plane text-base w-5 text-center"></i>
                <span>Surat Keluar</span>
            </a>

            <!-- Arsip Surat -->
            <a href="#" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900/80 font-medium text-sm transition">
                <i class="fa-solid fa-box-archive text-base w-5 text-center"></i>
                <span>Arsip Surat</span>
            </a>

            <!-- Kelola User -->
            <a href="#" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900/80 font-medium text-sm transition">
                <i class="fa-solid fa-users text-base w-5 text-center"></i>
                <span>Kelola User</span>
            </a>

            <!-- Laporan -->
            <a href="#" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900/80 font-medium text-sm transition">
                <i class="fa-solid fa-file-lines text-base w-5 text-center"></i>
                <span>Laporan</span>
            </a>
        </nav>
    </div>
</aside>