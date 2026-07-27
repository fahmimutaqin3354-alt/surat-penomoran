@extends('layouts.app')

@section('title', 'Data Surat Keluar')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                <i class="bi bi-envelope-paper"></i>
                Data Surat Keluar
            </h4>

            <a href="{{ route('surat_keluar.create') }}" class="btn btn-light">
                <i class="bi bi-plus-circle"></i>
                Tambah Surat
            </a>

        </div>

        <div class="card-body">

            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show">

                    {{ session('success') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"></button>

                </div>

            @endif

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark text-center">

                        <tr>

                            <th width="5%">No</th>

                            <th>Nomor Surat</th>

                            <th>Tanggal</th>

                            <th>Jenis Surat</th>

                            <th>Tujuan</th>

                            <th>Perihal</th>

                            <th>Status</th>

                            <th width="260">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($surat as $item)

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item->nomor_surat }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $item->jenis_surat }}
                            </td>

                            <td>
                                {{ $item->tujuan }}
                            </td>

                            <td>
                                {{ $item->perihal }}
                            </td>

                            <td class="text-center">

                                @if($item->status=='Draft')

                                    <span class="badge bg-secondary">
                                        Draft
                                    </span>

                                @elseif($item->status=='Dikirim')

                                    <span class="badge bg-warning text-dark">
                                        Dikirim
                                    </span>

                                @else

                                    <span class="badge bg-success">
                                        Selesai
                                    </span>

                                @endif

                            </td>

                            <td class="text-center">

                                <a href="{{ route('surat_keluar.show',$item->id) }}"
                                   class="btn btn-info btn-sm">

                                    <i class="bi bi-eye"></i>

                                </a>

                                <a href="{{ route('surat_keluar.preview',$item->id) }}"
                                   class="btn btn-primary btn-sm">

                                    <i class="bi bi-file-earmark-text"></i>

                                </a>

                                <a href="{{ route('surat_keluar.edit',$item->id) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <form action="{{ route('surat_keluar.destroy',$item->id) }}"
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

                            <td colspan="8" class="text-center text-muted">

                                Belum ada data surat keluar.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $surat->links() }}

            </div>

        </div>

    </div>

</div>

@endsection
