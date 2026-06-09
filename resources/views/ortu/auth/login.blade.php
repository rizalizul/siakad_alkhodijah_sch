<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <title>Login Orang Tua - SIAKAD Al Khodijah</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
</head>
<body>
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        <img class="img-fluid" src="{{ asset('assets/img/login.png') }}" alt="Logo" />
                    </div>
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Portal Orang Tua</h1>
                            <p class="account-subtitle">Akses Informasi Akademik Anak Anda</p>
                            <form method="POST" action="{{ route('ortu.login.submit') }}">
                                @csrf
                                <div class="form-group">
                                    <label>NIS / NISN Anak <span class="login-danger">*</span></label>
                                    <input class="form-control @error('nis') is-invalid @enderror" type="text" name="nis" value="{{ old('nis') }}" required>
                                    @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir Anak <span class="login-danger">*</span></label>
                                    <input class="form-control" type="date" name="tanggal_lahir" required>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success btn-block" type="submit">Masuk</button>
                                </div>
                            </form>
                            {{-- <div class="text-center mt-3">
                                <a href="{{ route('login') }}">← Ke Login Staf/Guru</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>