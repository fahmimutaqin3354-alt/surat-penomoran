@extends('layouts.app')

@section('title', 'Arsip Surat')

@section('content')

    <div class="breadcrumb-mini mb-2">
        <i class="bi bi-house"></i> Arsip <span class="mx-1">›</span> <span class="text-dark">Arsip Surat</span>
    </div>

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">Arsip Surat</h4>
            <div class="page-sub">Kelola arsip surat masuk dan keluar</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary d-flex align-items-center gap-1">
                <i class="bi bi-download"></i> Ekspor
            </button>
            <a href="{{ route('arsip.create') }}" class="btn btn-primary-soft d-flex align-items-center gap-1">
                <i class="bi bi-plus-lg"></i> Tambah Arsip
            </a>
        </div>
    </div>

    <div class="card-box p-3 mb-3">
        <form method="GET" action="{{ route('arsip.index') }}" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0"
                           placeholder="Cari nomor surat, judul, pengirim/penerima...">
                </div>
            </div>
            <div class="col-md-2">
                <select name="jenis" class="form-select">
                    <option value="">Semua Jenis</option>
                    <option value="masuk" @selected(request('jenis')=='masuk')>Surat Masuk</option>
                    <option value="keluar" @selected(request('jenis')=='keluar')>Surat Keluar</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList ?? [] as $kategori)
                        <option value="{{ $kategori }}" @selected(request('kategori')==$kategori)>{{ $kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunList ?? [] as $tahun)
                        <option value="{{ $tahun }}" @selected(request('tahun')==$tahun)>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-funnel"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <div class="card-box p-3">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:30px;"><input type="checkbox" class="form-check-input"></th>
                        <th>No. Surat</th>
                        <th>Jenis</th>
                        <th>Judul Surat</th>
                        <th>Pengirim / Penerima</th>
                        <th>Tanggal Surat</th>
                        <th>Tahun</th>
                        <th>Status</th>
                        <th>Arsip Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($arsipSurat as $surat)
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td class="fw-semibold">{{ $surat->no_surat }}</td>
                            <td>{{ $surat->jenis === 'masuk' ? 'Surat Masuk' : 'Surat Keluar' }}</td>
                            <td>{{ $surat->judul }}</td>
                            <td>{{ $surat->pengirim_penerima }}</td>
                            <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d M Y') }}</td>
                            <td>{{ $surat->tahun }}</td>
                            <td><span class="badge badge-soft-success rounded-pill px-3 py-2">{{ $surat->status }}</span></td>
                            <td>{{ $surat->arsip_oleh }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('arsip.show', $surat->id) }}"><i class="bi bi-eye me-2"></i>Lihat</a></li>
                                        <li><a class="dropdown-item" href="{{ route('arsip.edit', $surat->id) }}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li>
                                            <form action="{{ route('arsip.destroy', $surat->id) }}" method="POST" onsubmit="return confirm('Hapus arsip ini?')">
                                                @csrf @method('DELETE')
                                                <button class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Hapus</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">Belum ada data arsip surat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 px-1">
            <small class="text-muted">
                Menampilkan {{ $arsipSurat->firstItem() ?? 0 }} sampai {{ $arsipSurat->lastItem() ?? 0 }} dari {{ $arsipSurat->total() ?? 0 }} data
            </small>
            {{ $arsipSurat->links() }}
        </div>
    </div>

@endsection