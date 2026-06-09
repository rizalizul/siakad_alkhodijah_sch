<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
        <title>Pendaftaran Ditutup - Al Khodijah</title>
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
                                            <circle cx="26" cy="26" r="26" fill="#ffc107"/>
                                            <path d="M26 14V30" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                            <circle cx="26" cy="37" r="2" fill="white"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-warning">Pendaftaran Belum Dibuka</h2>
                                    <p class="lead">Mohon maaf, saat ini pendaftaran siswa baru belum dibuka atau sudah ditutup.</p>
                                    <p>Silakan periksa kembali halaman ini di lain waktu atau hubungi pihak sekolah untuk informasi lebih lanjut mengenai jadwal penerimaan siswa baru.</p>
                                    <hr>
                                    <p>Untuk informasi lebih lanjut, Anda dapat menghubungi staf administrasi sekolah melalui tombol di bawah ini.</p>
                                    @php
                                        // Ganti nomor ini dengan nomor WhatsApp Staf Administrasi Anda
                                        $nomorWhatsapp = '6289607515020'; // Contoh: 6281234567890 (tanpa + atau 0 di depan)
                                        $pesanWhatsapp = "Halo, saya ingin bertanya mengenai jadwal pendaftaran siswa baru.";
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