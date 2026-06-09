<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
        <title>Pendaftaran Berhasil - Al Khodijah</title>
        <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    </head>
    <body>
        <div class="main-wrapper">
            <div class="page-wrapper" style="margin-left: 0;">
                <div class="content container-fluid">
                    <div class="row justify-content-center mt-5">
                        <div class="col-lg-8 text-center">
                            <div class="card comman-shadow">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <svg width="80" height="80" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="26" cy="26" r="26" fill="#198754"/>
                                            <path d="M14.1 27.2L21.8 34.9L37.9 18.8" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-success">Pendaftaran Berhasil!</h2>
                                    <p class="lead">Terima kasih telah melakukan pendaftaran siswa baru di Al Khodijah Elementary School.</p>
                                    <p>Data Anda telah kami terima dan akan segera kami proses. Silakan tunggu informasi selanjutnya dari pihak sekolah mengenai jadwal verifikasi dan pembayaran formulir.</p>
                                    <hr>
                                    <p>Untuk informasi lebih lanjut, Anda dapat menghubungi staf administrasi sekolah melalui tombol di bawah ini.</p>
                                    @php
                                        // Ganti nomor ini dengan nomor WhatsApp Staf Administrasi Anda
                                        $nomorWhatsapp = '6289607515020'; // Contoh: 6281234567890 (tanpa + atau 0 di depan)
                                        $pesanWhatsapp = "Halo, saya ingin bertanya mengenai pendaftaran siswa baru.";
                                        $linkWhatsapp = "https://wa.me/{$nomorWhatsapp}?text=" . urlencode($pesanWhatsapp);
                                    @endphp
                                     
                                    <a href="{{ $linkWhatsapp }}" class="btn btn-success mt-3" target="_blank">
                                        <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
