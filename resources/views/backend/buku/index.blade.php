@extends('layouts.backend')

@section('title', 'Data buku')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table Buku</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Data Buku</h4>
                            <div class="ms-auto">
                                <a href="{{ route('buku.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-lg"></i> Tambah
                                </a>
                                <a href="{{ url('admin/import/buku') }}" class="btn btn-sm btn-success ms-2">
                                    <i class="bi bi-file-earmark-spreadsheet"></i> Import
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="tableBuku" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-left" scope="col">#</th>
                                        <th scope="col">Judul</th>
                                        <th class="text-left" scope="col">Tahun Terbit</th>
                                        <th class="text-left" scope="col">Stok</th>
                                        <th class="text-left" scope="col">Kode</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Penulis</th>
                                        <th scope="col">Penerbit</th>
                                        <th scope="col" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($buku as $item)
                                        <tr>
                                            <th class="text-left" scope="row">{{ $no++ }}</th>
                                            <td>{{ $item->judul }}</td>
                                            <td class="text-left">{{ $item->tahunTerbit }}</td>
                                            <td class="text-left">{{ $item->stok }}</td>
                                            <td class="text-left">{{ $item->code }}</td>
                                            <td>{{ $item->kategori->namaKategori }}</td>
                                            <td>{{ $item->penulis->namaPenulis }}</td>
                                            <td>{{ $item->penerbit->namaPenerbit }}</td>
                                            <td class="text-center">
                                                <div class="form-button-action">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-warning dropdown-toggle"
                                                            type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            Options
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <li>
                                                                <a href="{{ route('buku.edit', $item->id) }}"
                                                                    class="dropdown-item text-success edit-btn">
                                                                    <i class="bi bi-pencil"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('buku.show', $item->id) }}"
                                                                    class="dropdown-item text-warning detail-btn">
                                                                    <i class="bi bi-info-circle"></i> Detail
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('buku.destroy', $item->id) }}"
                                                                    class="dropdown-item text-danger delete-btn"
                                                                    data-confirm-delete="true">
                                                                    <i class="bi bi-trash"></i> Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
@endpush
