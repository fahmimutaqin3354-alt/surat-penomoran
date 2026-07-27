<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="font-black text-3xl text-white tracking-tight">
                        {{ __('Dashboard Overview') }}
                    </h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 border border-emerald-500/20 text-emerald-400">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Live
                    </span>
                </div>
                <p class="text-sm text-slate-400 mt-1">
                    Selamat datang kembali, <span class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-violet-400 to-pink-400">{{ Auth::user()->name }}</span>! Berikut adalah ringkasan aktivitas Anda hari ini.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <button class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-800/60 border border-slate-700/60 hover:bg-slate-800 text-slate-300 rounded-xl font-semibold text-xs backdrop-blur-xl transition duration-200 shadow-lg hover:border-slate-600">
                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v25a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                    </svg>
                    Filter Data
                </button>
                <a href="#" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-violet-600 to-pink-600 hover:from-violet-500 hover:to-pink-500 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-violet-600/25 hover:shadow-violet-600/40 hover:-translate-y-0.5 active:translate-y-0 transition duration-200">
                    <svg class="w-4 h-4 mr-1.5 -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Data
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Main Container Dark Theme -->
    <div class="py-8 bg-[#090d16] text-slate-200 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Banner Highlight / Welcome Hero -->
            <div class="relative overflow-hidden rounded-3xl bg-slate-900/60 border border-slate-800/80 p-8 text-white shadow-2xl backdrop-blur-xl">
                <!-- Background Ambient Glow -->
                <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-violet-600/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute left-1/2 -top-10 w-64 h-64 bg-pink-600/15 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-3 max-w-xl">
                        <span class="inline-block px-3 py-1 bg-violet-500/10 border border-violet-500/20 text-xs font-medium text-violet-300 rounded-full">
                            🚀 Produktivitas Hari Ini
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                            Kelola Semua Tugas dengan Lebih Efisien
                        </h3>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Anda telah menyelesaikan <span class="text-pink-400 font-bold underline decoration-pink-500/50">66%</span> dari total tugas minggu ini. Tetap semangat dan capai target Anda!
                        </p>
                    </div>
                    
                    <div class="flex items-center gap-4 bg-slate-800/40 border border-slate-700/50 backdrop-blur-md p-4 rounded-2xl">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-violet-600 to-pink-500 flex items-center justify-center text-white font-black text-lg shadow-lg shadow-pink-500/20">
                            66%
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Progres Keseluruhan</p>
                            <p class="text-sm font-bold text-white mt-0.5">8 dari 12 Selesai</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat Cards Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1: Total Tugas -->
                <div class="relative group bg-slate-900/50 backdrop-blur-xl p-6 rounded-3xl border border-slate-800/80 shadow-xl hover:border-violet-500/50 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-violet-500/10 rounded-bl-full group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Tugas</p>
                            <h3 class="text-4xl font-black text-white mt-2 tracking-tight">12</h3>
                            <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-violet-400 bg-violet-500/10 border border-violet-500/20 px-2.5 py-1 rounded-lg w-fit">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                <span>+2 minggu ini</span>
                            </div>
                        </div>
                        <div class="p-4 bg-gradient-to-br from-violet-600 to-indigo-600 text-white rounded-2xl shadow-lg shadow-violet-600/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Selesai -->
                <div class="relative group bg-slate-900/50 backdrop-blur-xl p-6 rounded-3xl border border-slate-800/80 shadow-xl hover:border-emerald-500/50 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/10 rounded-bl-full group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Tugas Selesai</p>
                            <h3 class="text-4xl font-black text-emerald-400 mt-2 tracking-tight">8</h3>
                            <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2.5 py-1 rounded-lg w-fit">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>66.7% Selesai</span>
                            </div>
                        </div>
                        <div class="p-4 bg-gradient-to-br from-emerald-500 to-teal-600 text-white rounded-2xl shadow-lg shadow-emerald-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Pending -->
                <div class="relative group bg-slate-900/50 backdrop-blur-xl p-6 rounded-3xl border border-slate-800/80 shadow-xl hover:border-amber-500/50 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/10 rounded-bl-full group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Menunggu (Pending)</p>
                            <h3 class="text-4xl font-black text-amber-400 mt-2 tracking-tight">4</h3>
                            <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-amber-400 bg-amber-500/10 border border-amber-500/20 px-2.5 py-1 rounded-lg w-fit">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3"></path>
                                </svg>
                                <span>Perlu tindakan</span>
                            </div>
                        </div>
                        <div class="p-4 bg-gradient-to-br from-amber-500 to-orange-600 text-white rounded-2xl shadow-lg shadow-amber-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Main Activity Panel -->
                <div class="lg:col-span-2 bg-slate-900/50 backdrop-blur-xl rounded-3xl border border-slate-800/80 shadow-xl p-6 sm:p-8 space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-800/80 pb-4">
                        <div>
                            <h3 class="text-xl font-bold text-white">Aktivitas Terakhir</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Daftar pembaruan tugas dan aktivitas terbaru</p>
                        </div>
                        <a href="#" class="text-xs font-bold text-pink-400 hover:text-pink-300 transition-colors">
                            Lihat Semua &rarr;
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Activity Item 1 -->
                        <div class="group flex items-center justify-between p-4 bg-slate-800/30 hover:bg-slate-800/60 rounded-2xl border border-slate-800 hover:border-slate-700 transition-all duration-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-200 group-hover:text-white transition-colors">Menyelesaikan Desain UI</p>
                                    <p class="text-xs text-slate-400">10 menit yang lalu • Oleh {{ Auth::user()->name }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                Selesai
                            </span>
                        </div>

                        <!-- Activity Item 2 -->
                        <div class="group flex items-center justify-between p-4 bg-slate-800/30 hover:bg-slate-800/60 rounded-2xl border border-slate-800 hover:border-slate-700 transition-all duration-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-200 group-hover:text-white transition-colors">Update Dokumentasi API</p>
                                    <p class="text-xs text-slate-400">2 jam yang lalu • Oleh Admin</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                Proses
                            </span>
                        </div>

                        <!-- Activity Item 3 -->
                        <div class="group flex items-center justify-between p-4 bg-slate-800/30 hover:bg-slate-800/60 rounded-2xl border border-slate-800 hover:border-slate-700 transition-all duration-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-xl bg-violet-500/10 text-violet-400 border border-violet-500/20 flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-200 group-hover:text-white transition-colors">Menambahkan Tugas Baru "Testing QA"</p>
                                    <p class="text-xs text-slate-400">Kemarin • Oleh {{ Auth::user()->name }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-violet-500/10 text-violet-400 border border-violet-500/20">
                                Baru
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Side Panel / User Profile Card -->
                <div class="relative overflow-hidden bg-slate-900/50 backdrop-blur-xl border border-slate-800/80 text-white rounded-3xl p-6 sm:p-8 flex flex-col justify-between shadow-xl">
                    <!-- Background Ambient Glow -->
                    <div class="absolute -top-12 -right-12 w-40 h-40 bg-pink-600/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-violet-600/10 rounded-full blur-2xl pointer-events-none"></div>

                    <div class="relative z-10 space-y-6">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 bg-slate-800/60 border border-slate-700/60 text-slate-300 text-xs font-semibold rounded-full">
                                Akun Aktif
                            </span>
                            <div class="w-3 h-3 bg-emerald-400 rounded-full animate-pulse"></div>
                        </div>

                        <div class="flex items-center gap-4 pt-2">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-violet-600 to-pink-500 p-0.5 shadow-lg shadow-violet-500/20">
                                <div class="w-full h-full bg-slate-900 rounded-[14px] flex items-center justify-center text-xl font-black text-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-white leading-tight">{{ Auth::user()->name }}</h4>
                                <p class="text-xs text-slate-400 mt-0.5 truncate max-w-[180px]">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <div class="p-4 bg-slate-800/40 border border-slate-700/50 rounded-2xl space-y-3">
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-400">Kelengkapan Profil</span>
                                <span class="text-pink-400 font-bold">85%</span>
                            </div>
                            <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-violet-600 to-pink-500 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10 pt-6">
                        <a href="{{ route('profile.edit') }}" class="flex items-center justify-center gap-2 w-full py-3 px-4 bg-slate-800/60 hover:bg-slate-800 active:bg-slate-700/80 border border-slate-700/60 rounded-xl text-sm font-bold text-slate-200 transition duration-200 shadow-sm">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Keloola Profil
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>