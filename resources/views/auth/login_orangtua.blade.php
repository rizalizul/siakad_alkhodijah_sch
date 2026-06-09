<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Orang Tua</title>

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
                            <h1>Portal Orang Tua<br />Al Khodijah Elementary School</h1>
                            <br />
                            <h2>Masuk</h2>

                            <form method="POST" action="{{ route('login.orangtua') }}">
                                @csrf
                                <div class="form-group">
                                    <label>NISN Anak</label>
                                    <input class="form-control" name="nisn" required />
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir Anak</label>
                                    <input class="form-control" name="tanggal_lahir" type="date" required />
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success btn-block" type="submit">Masuk</button>
                                </div>
                            </form>

                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}">← Kembali ke Login Admin</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
