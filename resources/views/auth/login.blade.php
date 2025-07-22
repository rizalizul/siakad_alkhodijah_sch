<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
        <title></title>

        <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.cs') }}s" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/icons/flags/flags.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    </head>
    <body>
        <div class="main-wrapper login-body">
            <div class="login-wrapper">
                <div class="container">
                    <div class="loginbox">
                        <div class="login-left">
                            <img class="img-fluid" src="assets/img/login.png" alt="Logo" />
                        </div>
                        <div class="login-right">
                            <div class="login-right-wrap">
                                <h1>Selamat Datang di SIAKAD <br />Al Khodijah Elementary School</h1>
                                <br />
                                <h2>Masuk</h2>

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>Email <span class="login-danger">*</span></label>
                                        <input class="form-control" type="email" name="email" required />
                                        <span class="profile-views"><i class="fas fa-user-circle"></i></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Kata Sandi <span class="login-danger">*</span></label>
                                        <input class="form-control" type="password" name="password" required />
                                        <span class="profile-views feather-eye toggle-password"></span>
                                    </div>
                                    ...
                                    <div class="form-group">
                                        <button class="btn btn-success btn-block" type="submit">Masuk</button>
                                    </div>
                                </form>

                                <div class="text-center mt-3">
                                    <a href="{{ route('login.orangtua') }}">← Ke Login Orang Tua</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>
    </body>
</html>
