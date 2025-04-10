@extends('layouts.backend')

@section('title', 'Data siswa')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table siswa</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Data siswa</h4>
                            <a href="{{ route('siswa.create') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-lg"></i> Tambah
                            </a>
                        </div>

                        <div class="card-body">
                            <table id="myTable1" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-left" scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Nis</th>
                                        <th scope="col">Nomor</th>
                                        <th scope="col" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($siswa as $item)
                                        <tr>
                                            <th class="text-left" scope="row">{{ $no++ }} </th>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->user->email }}</td>
                                            <td>{{ $item->nis }}</td>
                                            <td>{{ $item->no_hp }}</td>
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
                                                                <a href="{{ route('siswa.edit', $item->id) }}"
                                                                    class="dropdown-item text-success edit-btn">
                                                                    <i class="bi bi-pencil"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('siswa.destroy', $item->id) }}"
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
