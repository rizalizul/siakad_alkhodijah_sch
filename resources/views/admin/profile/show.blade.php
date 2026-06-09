@extends('layouts.app')
@section('title', 'Profil Saya')
@section('content')
<style>
    /* Menambahkan cursor pointer agar ikon terlihat bisa diklik */
    .toggle-password {
        cursor: pointer;
        /* Sedikit penyesuaian posisi agar sejajar dengan ikon di login */
        position: absolute;
        right: 15px;
        top: 70%;
        transform: translateY(-50%);
        color: #777;
    }
    /* Pastikan form-group memiliki posisi relatif agar ikon bisa diposisikan */
    .form-group {
        position: relative;
    }
</style>
<div class="page-header">
    <div class="row">
        <div class="col">
            <h3 class="page-title">Profil</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Profil Saya</li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        {{-- Pesan Sukses --}}
        @if (session('success_details'))
            <div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> {{ session('success_details') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if (session('success_password'))
            <div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> {{ session('success_password') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        {{-- Menampilkan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detail Profil</h5>
                <div class="row">
                    <div class="col-md-10 col-xl-6">
                        <form action="{{ route('profile.update.details') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="form-group">
                                <label>Peran (Role)</label>
                                <input type="text" class="form-control" value="{{ Str::ucfirst(str_replace('_', ' ', $user->role)) }}" readonly>
                            </div>

                            {{-- Tampilkan field tambahan jika user adalah guru --}}
                            @if($guru)
                                <hr>
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type="text" name="nip" class="form-control" value="{{ old('nip', $guru->nip) }}">
                                </div>
                                <div class="form-group">
                                    <label>Gelar</label>
                                    <input type="text" name="gelar" class="form-control" value="{{ old('gelar', $guru->gelar) }}">
                                </div>
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $guru->telepon) }}">
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control">{{ old('alamat', $guru->alamat) }}</textarea>
                                </div>
                            @endif
                            <button class="btn btn-success" type="submit">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Ubah Password</h5>
                <div class="row">
                    <div class="col-md-10 col-xl-6">
                        <form action="{{ route('profile.update.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control" required>
                                <span class="toggle-password"><i class="fas fa-eye"></i></span>
                            </div>
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="password" class="form-control" required>
                                <span class="toggle-password"><i class="fas fa-eye"></i></span>
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                                <span class="toggle-password"><i class="fas fa-eye"></i></span>
                            </div>
                            <button class="btn btn-success" type="submit">Ubah Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Cari SEMUA elemen span pembungkus ikon
    const togglePasswordSpans = document.querySelectorAll('.toggle-password');

    // Loop melalui setiap span yang ditemukan
    togglePasswordSpans.forEach(function(toggleSpan) {
        // Cari input field yang berada tepat sebelum span ini
        const passwordInput = toggleSpan.previousElementSibling;

        if (toggleSpan && passwordInput) {
            toggleSpan.addEventListener('click', function () {
                // Cek tipe input saat ini
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Cari ikon <i> di dalam span yang diklik
                const icon = this.querySelector('i');
                
                // Ganti class ikon antara fa-eye dan fa-eye-slash
                if (icon.classList.contains('fa-eye')) {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }
    });
});
</script>
@endpush
