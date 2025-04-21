@extends('layouts.profil')

@section('title', 'Profil')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>

                    <!-- Form to Edit Profile -->
                    <form id="formAccountSettings" method="POST" action="{{ route('profil.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- FOTO -->
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <!-- Image Preview -->
                                <img src="{{ $siswa->foto ? asset('images/siswa/' . $siswa->foto) : asset('default-avatar.png') }}"
                                    alt="user-avatar" class="d-block rounded" height="100" width="100"
                                    id="uploadedAvatar" />

                                <!-- Upload Button -->
                                <div class="button-wrapper">
                                    <label for="foto" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload Foto Baru</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="foto" name="foto"
                                            class="account-file-input @error('foto') is-invalid @enderror"
                                            accept="image/png, image/jpeg, image/jpg, image/gif" hidden />
                                    </label>

                                    <!-- Reset Button -->
                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4"
                                        id="resetAvatar">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>

                                    <!-- Error Message -->
                                    @error('foto')
                                        <div class="text-danger mt-1"><strong>{{ $message }}</strong></div>
                                    @enderror

                                    {{-- <p class="text-muted mb-0">Format: JPG, PNG, GIF. Max size 800KB.</p> --}}
                                </div>
                            </div>
                        </div>

                        <hr class="my-0" />

                        <!-- INPUT LAINNYA -->
                        <div class="card-body">
                            <div class="row">
                                <!-- Name -->
                                <div class="mb-3 col-md-6">
                                    <label for="firstName" class="form-label">Nama Lengkap</label>
                                    <input class="form-control" type="text" id="firstName" name="name"
                                        value="{{ old('name', $user->name) }}" autofocus />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" type="email" id="email" name="email"
                                        value="{{ old('email', $user->email) }}" readonly />
                                </div>

                                <!-- NIS -->
                                <div class="mb-3 col-md-6">
                                    <label for="nis" class="form-label">NIS</label>
                                    <input class="form-control" type="text" id="nis" name="nis"
                                        value="{{ old('nis', $siswa->nis) }}" readonly />
                                </div>

                                <!-- Phone -->
                                <div class="mb-3 col-md-6">
                                    <label for="phoneNumber" class="form-label">Nomor HP</label>
                                    <input type="text" id="phoneNumber" name="no_hp" class="form-control"
                                        value="{{ old('no_hp', $siswa->no_hp) }}" placeholder="08xxxxxxxxxx" />
                                    @error('no_hp')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Alamat -->
                                <div class="mb-3 col-md-12">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ old('alamat', $siswa->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                                <button type="reset" class="btn btn-outline-secondary">Batal</button>
                            </div>
                        </div>
                    </form>
                    <!-- /Form -->
                </div>

                <!-- Delete Account Section -->
                <div class="card">
                    <h5 class="card-header">Hapus Akun</h5>
                    <div class="card-body">
                        <div class="mb-3 col-12 mb-0">
                            <div class="alert alert-warning">
                                <h6 class="alert-heading fw-bold mb-1">Yakin ingin menghapus akun?</h6>
                                <p class="mb-0">Setelah dihapus, akun tidak dapat dikembalikan. Harap dipastikan.</p>
                            </div>
                        </div>
                        <form id="formAccountDeactivation" method="POST" action="{{ route('profil.destroy') }}">
                            @csrf
                            @method('DELETE')
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="accountActivation"
                                    id="accountActivation" required />
                                <label class="form-check-label" for="accountActivation">
                                    Saya mengonfirmasi penghapusan akun saya
                                </label>
                            </div>
                            <button type="submit" class="btn btn-danger deactivate-account">Hapus Akun</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const fileInput = document.getElementById('foto');
        const avatar = document.getElementById('uploadedAvatar');
        const resetBtn = document.getElementById('resetAvatar');
        const originalSrc = avatar.src;

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatar.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        resetBtn.addEventListener('click', function() {
            fileInput.value = '';
            avatar.src = originalSrc;
        });
    </script>
@endpush
