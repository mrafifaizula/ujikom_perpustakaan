@extends('layouts.backend')

@section('title', 'Import excel buku')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Import excel buku</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Import excel buku</h4>
                            <div class="ms-auto">
                                <a href="{{ route('buku.index') }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-box-arrow-left"></i> kembali
                                </a>
                                <a href="{{ route('export.buku') }}" class="btn btn-sm btn-success">
                                    Download CSV
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('import.buku') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Upload File Excel:</label>
                                    <input type="file" name="file"
                                        class="form-control @error('file') is-invalid @enderror">
                                    @error('file')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <button class="btn btn-success btn-sm" type="submit">Import</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
