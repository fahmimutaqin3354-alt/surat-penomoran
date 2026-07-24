<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="font-black text-3xl text-gray-900 tracking-tight">
                        {{ __('Dashboard Overview') }}
                    </h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                        Live
                    </span>
                </div>
                <p class="text-sm text-gray-500 mt-1">
                    Selamat datang kembali, <span class="font-bold text-indigo-600 underline decoration-indigo-300 decoration-2">{{ Auth::user()->name }}</span>! Berikut adalah ringkasan aktivitas Anda hari ini.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <button class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl font-semibold text-xs text-gray-700 hover:bg-gray-50 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v25a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                    </svg>
                    Filter Data
                </button>
                <a href="#" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:-translate-y-0.5 active:translate-y-0 transition duration-200">
                    <svg class="w-4 h-4 mr-1.5 -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Data
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Banner Highlight / Welcome Hero -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-900 via-indigo-800 to-purple-900 p-8 text-white shadow-2xl shadow-indigo-900/20">
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute right-40 -top-10 w-48 h-48 bg-pink-500/20 rounded-full blur-2xl pointer-events-none"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-2 max-w-xl">
                        <span class="inline-block px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 text-xs font-medium text-purple-200 rounded-full">
                            🚀 Produktivitas Hari Ini
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                            Kelola Semua Tugas dengan Lebih Efisien
                        </h3>
                        <p class="text-indigo-200 text-sm leading-relaxed">
                            Anda telah menyelesaikan <span class="text-white font-bold underline">66%</span> dari total tugas minggu ini. Tetap semangat dan capai target Anda!
                        </p>
                    </div>
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-emerald-400 to-teal-300 flex items-center justify-center text-gray-900 font-bold text-xl shadow-lg shadow-emerald-500/30">
                            66%
                        </div>
                        <div>
                            <p class="text-xs text-indigo-200 font-medium">Progres Keseluruhan</p>
                            <p class="text-sm font-bold text-white">8 dari 12 Selesai</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat Cards Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1: Total Tugas -->
                <div class="relative group bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-500/10 rounded-bl-full group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Tugas</p>
                            <h3 class="text-4xl font-black text-gray-900 mt-2 tracking-tight">12</h3>
                            <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg w-fit">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                <span>+2 minggu ini</span>
                            </div>
                        </div>
                        <div class="p-4 bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-2xl shadow-lg shadow-indigo-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Selesai -->
                <div class="relative group bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/10 rounded-bl-full group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Tugas Selesai</p>
                            <h3 class="text-4xl font-black text-emerald-600 mt-2 tracking-tight">8</h3>
                            <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg w-fit">
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
                <div class="relative group bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/10 rounded-bl-full group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Menunggu (Pending)</p>
                            <h3 class="text-4xl font-black text-amber-500 mt-2 tracking-tight">4</h3>
                            <div class="flex items-center gap-1.5 mt-2 text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-lg w-fit">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3"></path>
                                </svg>
                                <span>Perlu tindakan</span>
                            </div>
                        </div>
                        <div class="p-4 bg-gradient-to-br from-amber-400 to-orange-500 text-white rounded-2xl shadow-lg shadow-amber-500/30">
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
                <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Aktivitas Terakhir</h3>
                            <p class="text-xs text-gray-400 mt-0.5">Daftar pembaruan tugas dan aktivitas terbaru</p>
                        </div>
                        <a href="#" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
                            Lihat Semua &rarr;
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Activity Item 1 -->
                        <div class="group flex items-center justify-between p-4 bg-slate-50 hover:bg-gradient-to-r hover:from-slate-50 hover:to-emerald-50/50 rounded-2xl border border-transparent hover:border-emerald-100 transition-all duration-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 group-hover:text-emerald-900 transition-colors">Menyelesaikan Desain UI</p>
                                    <p class="text-xs text-gray-400">10 menit yang lalu • Oleh {{ Auth::user()->name }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                Selesai
                            </span>
                        </div>

                        <!-- Activity Item 2 -->
                        <div class="group flex items-center justify-between p-4 bg-slate-50 hover:bg-gradient-to-r hover:from-slate-50 hover:to-amber-50/50 rounded-2xl border border-transparent hover:border-amber-100 transition-all duration-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 group-hover:text-amber-900 transition-colors">Update Dokumentasi API</p>
                                    <p class="text-xs text-gray-400">2 jam yang lalu • Oleh Admin</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">
                                Proses
                            </span>
                        </div>

                        <!-- Activity Item 3 -->
                        <div class="group flex items-center justify-between p-4 bg-slate-50 hover:bg-gradient-to-r hover:from-slate-50 hover:to-indigo-50/50 rounded-2xl border border-transparent hover:border-indigo-100 transition-all duration-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 group-hover:text-indigo-900 transition-colors">Menambahkan Tugas Baru "Testing QA"</p>
                                    <p class="text-xs text-gray-400">Kemarin • Oleh {{ Auth::user()->name }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 border border-indigo-200">
                                Baru
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Side Panel / User Profile Card -->
                <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white rounded-3xl p-6 sm:p-8 flex flex-col justify-between shadow-xl">
                    <!-- Decorative blurred background shapes -->
                    <div class="absolute -top-12 -right-12 w-40 h-40 bg-indigo-500/20 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-purple-500/20 rounded-full blur-2xl"></div>

                    <div class="relative z-10 space-y-6">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 bg-white/10 backdrop-blur-md border border-white/10 text-indigo-200 text-xs font-semibold rounded-full">
                                Akun Aktif
                            </span>
                            <div class="w-3 h-3 bg-emerald-400 rounded-full animate-pulse"></div>
                        </div>

                        <div class="flex items-center gap-4 pt-2">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-500 to-pink-500 p-0.5 shadow-lg">
                                <div class="w-full h-full bg-slate-900 rounded-[14px] flex items-center justify-center text-xl font-black text-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-white leading-tight">{{ Auth::user()->name }}</h4>
                                <p class="text-xs text-indigo-300 mt-0.5 truncate max-w-[180px]">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <div class="p-4 bg-white/5 border border-white/10 rounded-2xl space-y-3">
                            <div class="flex justify-between text-xs">
                                <span class="text-indigo-200">Kelengkapan Profil</span>
                                <span class="text-white font-bold">85%</span>
                            </div>
                            <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-indigo-500 to-pink-500 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10 pt-6">
                        <a href="{{ route('profile.edit') }}" class="flex items-center justify-center gap-2 w-full py-3 px-4 bg-white/10 hover:bg-white/20 active:bg-white/30 backdrop-blur-md border border-white/15 rounded-xl text-sm font-bold text-white transition duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Kelola Profil
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>