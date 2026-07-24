@extends('layouts.app')

@section('title', 'Surat Keluar')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">Surat Keluar</h2>
            <p class="text-muted mb-0">
                Kelola seluruh data surat keluar perusahaan.
            </p>
        </div>

        <a href="{{ route('surat_keluar.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Tambah Surat
        </a>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-4">

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Cari nomor atau perihal surat">

                </div>

            </div>

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-primary">

                <tr>

                    <th>No</th>
                    <th>Nomor Surat</th>
                    <th>Perihal</th>
                    <th>Tujuan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>

                </tr>

                </thead>

               <tbody>

@forelse($surat as $item)

<tr>

    <td>{{ $loop->iteration }}</td>

    <td>{{ $item->nomor_surat }}</td>

    <td>{{ $item->perihal }}</td>

    <td>{{ $item->tujuan }}</td>

    <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}</td>

    <td>

        @if($item->status == 'Draft')
            <span class="badge bg-secondary">{{ $item->status }}</span>
        @elseif($item->status == 'Dikirim')
            <span class="badge bg-primary">{{ $item->status }}</span>
        @else
            <span class="badge bg-success">{{ $item->status }}</span>
        @endif

    </td>

    <td>

        <a href="{{ route('surat_keluar.show', $item->id) }}"
            class="btn btn-info btn-sm text-white">

            <i class="bi bi-eye"></i>

        </a>

        <a href="{{ route('surat_keluar.edit', $item->id) }}"
            class="btn btn-warning btn-sm">

            <i class="bi bi-pencil-square"></i>

        </a>

        <form action="{{ route('surat_keluar.destroy', $item->id) }}"
              method="POST"
              class="d-inline">

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="btn btn-danger btn-sm"
                onclick="return confirm('Yakin ingin menghapus surat ini?')">

                <i class="bi bi-trash"></i>

            </button>

        </form>

    </td>

</tr>

@empty

<tr>

    <td colspan="7" class="text-center">

        Belum ada data surat keluar.

    </td>

</tr>

@endforelse

</tbody>

            </table>
            <div class="mt-3">
    {{ $surat->links() }}
</div>

        </div>

    </div>

</div>

@endsection
