<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
        <title>Formulir Pendaftaran Siswa Baru - Al Khodijah</title>
        <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    </head>
    <body>
        <div class="main-wrapper">
            <div class="page-wrapper" style="margin-left: 0;">
                <div class="content container-fluid">
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="page-sub-header">
                                    <h3 class="page-title">Formulir Pendaftaran Siswa Baru</h3>
                                    <ul class="breadcrumb">
                                        {{-- <li class="breadcrumb-item active">Tahun Ajaran {{ \App\Models\TahunAjaran::where('is_active', true)->first()->nama ?? '' }}</li> --}}
                                        <li class="breadcrumb-item active">Tahun Ajaran {{ $tahunAjaranPpdb->nama }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card comman-shadow">
                                <div class="card-body">
                                    <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12"><h5 class="form-title"><span>Informasi Siswa</span></h5></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Nama Lengkap <span class="login-danger">*</span></label><input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" value="{{ old('nama') }}" required /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Nama Panggilan <span class="login-danger">*</span></label><input type="text" name="nama_panggilan" class="form-control" placeholder="Masukkan Nama Panggilan" value="{{ old('nama_panggilan') }}" required /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>NISN</label><input type="tel" name="nisn" class="form-control" placeholder="Masukkan NISN (jika ada)" value="{{ old('nisn') }}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Jenis Kelamin <span class="login-danger">*</span></label><select name="jenis_kelamin" class="form-control" required><option value="">Pilih Jenis Kelamin</option><option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option><option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option></select></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Tempat Lahir <span class="login-danger">*</span></label><input type="text" name="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir" value="{{ old('tempat_lahir') }}" required /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Tanggal Lahir <span class="login-danger">*</span></label><input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Agama <span class="login-danger">*</span></label><input type="text" name="agama" class="form-control" placeholder="Masukkan Agama" value="{{ old('agama', 'Islam') }}" required /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Pendidikan Sebelumnya</label><input type="text" name="pendidikan_sebelumnya" placeholder="Contoh: TK Bina Insani" class="form-control" value="{{ old('pendidikan_sebelumnya') }}" /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Alamat Siswa <span class="login-danger">*</span></label><textarea name="alamat_siswa" class="form-control" placeholder="Masukkan Alamat Lengkap Siswa" required>{{ old('alamat_siswa') }}</textarea></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>No WhatsApp Siswa</label><input type="tel" name="no_wa_siswa" placeholder="Masukkan No. WA (jika ada)" class="form-control" value="{{ old('no_wa_siswa') }}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" /></div></div>

                                            <div class="col-12 mt-4"><h5 class="form-title"><span>Informasi Orang Tua</span></h5></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Nama Ayah <span class="login-danger">*</span></label><input type="text" id="nama_ayah" name="nama_ayah" class="form-control" placeholder="Masukkan Nama Lengkap Ayah" value="{{ old('nama_ayah') }}" required /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Pekerjaan Ayah <span class="login-danger">*</span></label><input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah" class="form-control" placeholder="Contoh: Karyawan Swasta" value="{{ old('pekerjaan_ayah') }}" required /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Nama Ibu <span class="login-danger">*</span></label><input type="text" name="nama_ibu" class="form-control" placeholder="Masukkan Nama Lengkap Ibu" value="{{ old('nama_ibu') }}" required /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Pekerjaan Ibu <span class="login-danger">*</span></label><input type="text" name="pekerjaan_ibu" class="form-control" placeholder="Contoh: Ibu Rumah Tangga" value="{{ old('pekerjaan_ibu') }}" required /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>No WhatsApp Ortu/Wali <span class="login-danger">*</span></label><input type="tel" name="no_wa_ortu" class="form-control" placeholder="Contoh: 081234567890" value="{{ old('no_wa_ortu') }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '');" /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Alamat Orang Tua <span class="login-danger">*</span></label><textarea id="alamat_ortu" name="alamat_ortu" class="form-control" placeholder="Masukkan Alamat Lengkap Orang Tua" required>{{ old('alamat_ortu') }}</textarea></div></div>
                                            
                                            <div class="col-12 mt-4"><h5 class="form-title"><span>Informasi Wali (Jika berbeda dengan Ayah/Ibu)</span></h5></div>
                                            <div class="col-12"><div class="form-check mb-3"><input class="form-check-input" type="checkbox" id="use_ayah_data"><label class="form-check-label" for="use_ayah_data">Gunakan data Ayah sebagai Wali</label></div></div>
                                            <div class="col-md-4"><div class="form-group local-forms"><label>Nama Wali</label><input type="text" id="nama_wali" name="nama_wali" class="form-control" placeholder="Masukkan Nama Wali" value="{{ old('nama_wali') }}" /></div></div>
                                            <div class="col-md-4"><div class="form-group local-forms"><label>Pekerjaan Wali</label><input type="text" id="pekerjaan_wali" name="pekerjaan_wali" class="form-control" placeholder="Masukkan Pekerjaan Wali" value="{{ old('pekerjaan_wali') }}" /></div></div>
                                            <div class="col-md-4"><div class="form-group local-forms"><label>Alamat Wali</label><textarea id="alamat_wali" name="alamat_wali" class="form-control" placeholder="Masukkan Alamat Wali">{{ old('alamat_wali') }}</textarea></div></div>

                                            <div class="col-12 mt-4"><h5 class="form-title"><span>Dokumen</span></h5><p class="text-muted">Upload file dalam format PDF, JPG, atau PNG. Ukuran maksimal 2MB.</p></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Kartu Keluarga <span class="login-danger">*</span></label><input type="file" name="kk" class="form-control" required /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>KTP Ayah <span class="login-danger">*</span></label><input type="file" name="ktp_ayah" class="form-control" required /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>KTP Ibu <span class="login-danger">*</span></label><input type="file" name="ktp_ibu" class="form-control" required /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Akta Kelahiran <span class="login-danger">*</span></label><input type="file" name="akta_kelahiran" class="form-control" required /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Kartu Identitas Anak (KIA)</label><input type="file" name="kia" class="form-control" /></div></div>
                                            <div class="col-md-6"><div class="form-group local-forms"><label>Foto Siswa (3x4) <span class="login-danger">*</span></label><input type="file" name="foto" class="form-control" required /></div></div>

                                            <div class="col-12"><div class="student-submit text-end"><button type="submit" class="btn btn-success">Kirim Pendaftaran</button></div></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('use_ayah_data').addEventListener('change', function() {
                const namaAyah = document.getElementById('nama_ayah').value;
                const pekerjaanAyah = document.getElementById('pekerjaan_ayah').value;
                const alamatOrtu = document.getElementById('alamat_ortu').value;
                
                if (this.checked) {
                    document.getElementById('nama_wali').value = namaAyah;
                    document.getElementById('pekerjaan_wali').value = pekerjaanAyah;
                    document.getElementById('alamat_wali').value = alamatOrtu;
                } else {
                    document.getElementById('nama_wali').value = '';
                    document.getElementById('pekerjaan_wali').value = '';
                    document.getElementById('alamat_wali').value = '';
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                // Daftar nama field yang ingin di-capitalize
                const fieldsToCapitalize = [
                    'nama', 'nama_panggilan', 'tempat_lahir', 'agama', 'pendidikan_sebelumnya',
                    'nama_ayah', 'pekerjaan_ayah', 'nama_ibu', 'pekerjaan_ibu',
                    'nama_wali', 'pekerjaan_wali'
                ];

                // Fungsi untuk mengubah string menjadi Capitalized Case
                function capitalizeWords(str) {
                    if (!str) return '';
                    return str.toLowerCase().replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); });
                }

                // Terapkan event listener ke setiap input yang cocok
                fieldsToCapitalize.forEach(function(fieldName) {
                    const input = document.querySelector(`input[name="${fieldName}"]`);
                    if (input) {
                        input.addEventListener('input', function() {
                            // Simpan posisi kursor agar tidak loncat ke akhir
                            let start = this.selectionStart;
                            let end = this.selectionEnd;
                            this.value = capitalizeWords(this.value);
                            this.setSelectionRange(start, end);
                        });
                    }
                });
            });
        </script>
    </body>
</html>