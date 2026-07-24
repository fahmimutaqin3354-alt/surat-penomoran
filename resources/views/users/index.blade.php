@extends('layouts.app')

@section('title', 'Kelola Users')

@section('content')

    <div class="breadcrumb-mini mb-2">
        <i class="bi bi-house"></i> Pengaturan <span class="mx-1">›</span> <span class="text-dark">Kelola Users</span>
    </div>

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">Kelola Users</h4>
            <div class="page-sub">Kelola data pengguna sistem</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary d-flex align-items-center gap-1">
                <i class="bi bi-upload"></i> Import
            </button>
            <a href="{{ route('pengaturan.users.create') }}" class="btn btn-primary-soft d-flex align-items-center gap-1">
                <i class="bi bi-plus-lg"></i> Tambah User
            </a>
        </div>
    </div>

    <div class="card-box p-3">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:40px;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Unit Kerja</th>
                        <th>Status</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        @php
                            $roleBadge = match(strtolower($user->role)) {
                                'admin' => 'badge-soft-info',
                                'operator' => 'badge-soft-purple',
                                'verifikator' => 'badge-soft-purple',
                                default => 'badge-soft-success',
                            };
                            $statusBadge = $user->status === 'Aktif' ? 'badge-soft-success' : 'badge-soft-warning';
                        @endphp
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge {{ $roleBadge }} rounded-pill px-3 py-2">{{ $user->role }}</span></td>
                            <td>{{ $user->unit_kerja }}</td>
                            <td><span class="badge {{ $statusBadge }} rounded-pill px-3 py-2">{{ $user->status }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d M Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('pengaturan.users.edit', $user->id) }}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li>
                                            <form action="{{ route('pengaturan.users.toggle', $user->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button class="dropdown-item">
                                                    <i class="bi bi-toggle2-on me-2"></i>{{ $user->status === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('pengaturan.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
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
                            <td colspan="8" class="text-center text-muted py-4">Belum ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 px-1">
            <small class="text-muted">
                Menampilkan {{ $users->firstItem() ?? 0 }} sampai {{ $users->lastItem() ?? 0 }} dari {{ $users->total() ?? 0 }} data
            </small>
            {{ $users->links() }}
        </div>
    </div>

@endsection