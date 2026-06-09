<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <title>Login - SIAKAD Al Khodijah</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <style>
        .toggle-password {
            cursor: pointer;
        }
    </style>
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
                            <h1>Selamat Datang di SIAKAD <br />Al Khodijah Elementary School</h1>
                            <br />
                            <h2>Masuk</h2>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email <span class="login-danger">*</span></label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{ old('email') }}" required autofocus />
                                    <span class="profile-views"><i class="fas fa-user-circle"></i></span>
                                </div>
                                @error('email')
                                    <div class="text-danger mb-3" style="font-size: 14px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-group">
                                    <label for="password">Kata Sandi <span class="login-danger">*</span></label>
                                    <input class="form-control" type="password" name="password" id="password" required />
                                    <span class="profile-views toggle-password">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                
                                <div class="form-group">
                                    <button class="btn btn-success btn-block" type="submit">Masuk</button>
                                </div>
                            </form>

                            <div class="text-center mt-3">
                                {{-- <a href="#">← Ke Login Orang Tua</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelector('.toggle-password');
            const passwordInput = document.querySelector('#password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    // Toggle tipe input
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    const icon = this.querySelector('i');
                    
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
    </script>
</body>
</html>
