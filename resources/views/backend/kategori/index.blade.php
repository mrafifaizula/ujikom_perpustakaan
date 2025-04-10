@extends('layouts.backend')

@section('title', 'Data kategori')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table Kategori</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Data Kategori</h4>
                            <div class="ms-auto">
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#createModal" title="Tambah">
                                    <i class="bi bi-plus-lg"></i> Tambah
                                </button>
                                <a href="{{ url('admin/import/kategori') }}" class="btn btn-sm btn-success ms-2">
                                    <i class="bi bi-file-earmark-spreadsheet"></i> Import
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="myTable1" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-left" scope="col">#</th>
                                        <th scope="col">Nama Kategori</th>
                                        <th scope="col" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($kategori as $item)
                                        <tr>
                                            <th class="text-left" scope="row">{{ $no++ }}</th>
                                            <td>{{ $item->namaKategori }}</td>
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
                                                                <button class="dropdown-item text-success btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editModal{{ $item->id }}">
                                                                    <i class="bi bi-pencil"></i> Edit
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('kategori.destroy', $item->id) }}"
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

    {{-- Start Modal Create --}}
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('kategori.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <label for="namaKategori">Nama Kategori</label>
                            <input type="text" placeholder="Nama Kategori"
                                class="form-control @error('namaKategori') is-invalid @enderror" name="namaKategori">
                        </div>
                        <div class="mb-2">
                            <button class="btn btn-sm btn-success" type="submit">Simpan</button>
                            <button class="btn btn-sm btn-warning" type="reset">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Create --}}

    {{-- Start Edit Modal --}}
    @foreach ($kategori as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('kategori.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="namaKategori" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" id="namaKategori" name="namaKategori"
                                    value="{{ $item->namaKategori }}" required>
                            </div>
                            <div class="mb-2">
                                <button class="btn btn-sm btn-success" type="submit">Simpan</button>
                                <button class="btn btn-sm btn-warning" type="reset">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- End Edit Modal --}}
@endsection
