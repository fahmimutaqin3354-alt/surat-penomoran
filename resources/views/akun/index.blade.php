@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')

<div class="px-4 py-6 max-w-3xl mx-auto">

    <div class="mb-6">
        <h4 class="text-2xl font-bold text-white">Pengaturan Akun</h4>
        <p class="text-sm text-slate-400 mt-1">Kelola informasi profil dan password akun kamu</p>
    </div>

    @if (session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-lg px-4 py-3 mb-5 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 rounded-lg px-4 py-3 mb-5">
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ================= INFORMASI PROFIL ================= --}}
    <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 mb-6">

        <h5 class="text-base font-semibold text-white mb-1">Informasi Profil</h5>
        <p class="text-sm text-slate-400 mb-4">Ubah nama dan email akun kamu</p>

        <form action="{{ route('akun.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Nama</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', auth()->user()->name) }}"
                           class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Email</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email', auth()->user()->email) }}"
                           class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                </div>

            </div>

            <div class="mt-5">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

    {{-- ================= GANTI PASSWORD ================= --}}
    <div class="bg-slate-900 border border-slate-800 rounded-xl p-6">

        <h5 class="text-base font-semibold text-white mb-1">Ganti Password</h5>
        <p class="text-sm text-slate-400 mb-4">
            Masukkan password lama untuk konfirmasi, lalu tentukan password baru
        </p>

        <form action="{{ route('akun.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4">

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Password Lama</label>
                    <input type="password"
                           name="current_password"
                           class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Password Baru</label>
                        <input type="password"
                               name="password"
                               class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               required>
                        <p class="text-xs text-slate-500 mt-1">Minimal 8 karakter</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Konfirmasi Password Baru</label>
                        <input type="password"
                               name="password_confirmation"
                               class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               required>
                    </div>

                </div>

            </div>

            <div class="mt-5">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Ubah Password
                </button>
            </div>

        </form>
    </div>

</div>

@endsection