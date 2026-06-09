<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Siswa; // Pastikan model Siswa di-import

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswas = [
            [
                'nisn' => '3176048474',
                'nama' => 'Achmad Nurudin Akbar',
                'nama_panggilan' => 'Akbar',
                'tempat_lahir' => 'Mojokerto',
                'tanggal_lahir' => '2017-03-08',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'pendidikan_sebelumnya' => 'TK Bina Insani',
                'alamat_siswa' => 'Dsn Sambirejo RT 05 RW 06 Ds. Wringinrejo Kab. Mojokerto',
                'nama_ayah' => 'Davi Feri Anus',
                'pekerjaan_ayah' => 'Karyawan Swasta',
                'nama_ibu' => 'Liza Isdarwanti',
                'pekerjaan_ibu' => 'Wiraswasta',
                'alamat_ortu' => 'Dsn Sambirejo RT 005 RW 006',
                'no_wa_ortu' => '089608972661',
            ],
            [
                'nisn' => '3175920627',
                'nama' => 'Adzqia Sabiya Mahiswari',
                'nama_panggilan' => 'Sabiya',
                'tempat_lahir' => 'Sidoarjo',
                'tanggal_lahir' => '2017-12-29',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'pendidikan_sebelumnya' => 'TK Bina Insani',
                'alamat_siswa' => 'Dsn Sambirejo RT 05 RW 06 Ds. Wringinrejo Kab. Mojokerto',
                'nama_ayah' => 'Mochamad Rizqi R',
                'pekerjaan_ayah' => 'Karyawan Swasta',
                'nama_ibu' => 'Chistya Maulidya',
                'pekerjaan_ibu' => 'Karyawan Swasta',
                'alamat_ortu' => 'Dsn Sambirejo RT 005 RW 006',
                'no_wa_ortu' => '089608972661',
            ],
            [
                'nisn' => '3179387977',
                'nama' => 'Ahmad Mahendra Afuww Pradipta',
                'nama_panggilan' => 'Mahen',
                'tempat_lahir' => 'Mojokerto',
                'tanggal_lahir' => '2017-06-29',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'pendidikan_sebelumnya' => 'TK Dharma Wanita Meri',
                'alamat_siswa' => 'Perum Wikarsa F 16 Ds. Kenanten Kec. Puri Kab. Mojokerto',
                'nama_ayah' => 'Afif Syarifudin Muzakki',
                'pekerjaan_ayah' => 'Karyawan Swasta',
                'nama_ibu' => 'Lady Zuhriah Nur L',
                'pekerjaan_ibu' => 'Wiraswasta',
                'alamat_ortu' => 'Perum Wikarsa F16',
                'no_wa_ortu' => '089608972661',
            ],
            [
                'nisn' => '0178336992',
                'nama' => 'Ahmad Rijal Muzakki',
                'nama_panggilan' => 'Rijal',
                'tempat_lahir' => 'Mojokerto',
                'tanggal_lahir' => '2017-01-13',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'pendidikan_sebelumnya' => 'TK Islam Miftahul Hikmah',
                'alamat_siswa' => 'Kedung Mulang RT 13 RW 03 Kel. Surodinawan Kota Mojokerto',
                'nama_ayah' => 'Muhsin',
                'pekerjaan_ayah' => 'Penjahit',
                'nama_ibu' => 'Masruroh',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'alamat_ortu' => 'Kedung Mulang RT 013 RW 003',
                'no_wa_ortu' => '089608972661',
            ],
            [
                'nisn' => '3174552524',
                'nama' => 'Aisyah Nur Hermansyah',
                'nama_panggilan' => 'Aisyah',
                'tempat_lahir' => 'Mojokerto',
                'tanggal_lahir' => '2017-05-24',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'pendidikan_sebelumnya' => 'TK Muslimat NU 007 Nurul Huda',
                'alamat_siswa' => 'Prajurit Kulon Gang Baru Kec. Prajurit Kulon Kota Mojokerto',
                'nama_ayah' => 'Herman Iswanto',
                'pekerjaan_ayah' => 'Kuli Bangunan',
                'nama_ibu' => 'Titin Nurhayati',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'alamat_ortu' => 'Prajurit Kulon Gg Baru',
                'no_wa_ortu' => '089608972661',
            ],
            [
                'nisn' => '3173086698',
                'nama' => 'Aqila Mufia Fadheela',
                'nama_panggilan' => 'Aqila',
                'tempat_lahir' => 'Mojokerto',
                'tanggal_lahir' => '2017-11-12',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'pendidikan_sebelumnya' => 'TK \'Aisyiyah Bustanul Athfal',
                'alamat_siswa' => 'Wisma Sooko Indah Jl Tongkol 3 No 235 Sooko Kab. Mojokerto',
                'nama_ayah' => 'Wiratsongko',
                'pekerjaan_ayah' => 'Karyawan Swasta',
                'nama_ibu' => 'Dany Teftiani Karina',
                'pekerjaan_ibu' => 'Wiraswasta',
                'alamat_ortu' => 'Wisma Sooko Indah Jl Tongkol 3 No 235',
                'no_wa_ortu' => '089608972661',
            ],
            [
                'nisn' => '3176516558',
                'nama' => 'Asyakila Firza Azzafa',
                'nama_panggilan' => 'Syakila',
                'tempat_lahir' => 'Mojokerto',
                'tanggal_lahir' => '2017-06-07',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'pendidikan_sebelumnya' => 'TK Muslimat NU 007 Nurul Huda',
                'alamat_siswa' => 'Ds. Wringin Rejo RT 02 RW 01 Kec. Sooko Kab. Mojokerto',
                'nama_ayah' => 'Iswahyudi Pristiawan',
                'pekerjaan_ayah' => 'Karyawan Swasta',
                'nama_ibu' => 'Yuli Nur Isnaini',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'alamat_ortu' => 'Wringinrejo RT 002 RW 001',
                'no_wa_ortu' => '089608972661',
            ],
            [
                'nisn' => '3188707058',
                'nama' => 'Aulia Syahila Salsabila',
                'nama_panggilan' => 'Aulia',
                'tempat_lahir' => 'Mojokerto',
                'tanggal_lahir' => '2018-01-18',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'pendidikan_sebelumnya' => 'TK IMTAQ Mojokerto',
                'alamat_siswa' => 'Dsn Unggahan RT 02 RW 08 Desa Banjaragung Kec. Puri',
                'nama_ayah' => 'Danny Hermanto',
                'pekerjaan_ayah' => 'Wiraswasta',
                'nama_ibu' => 'Newi Maulita',
                'pekerjaan_ibu' => 'Wiraswasta',
                'alamat_ortu' => 'Dsn. Unggahan RT 002 RW 008',
                'no_wa_ortu' => '089608972661',
            ],
            [
                'nisn' => '3173973413',
                'nama' => 'Diajeng Gendhis Tifanani',
                'nama_panggilan' => 'Gendhis',
                'tempat_lahir' => 'Mojokerto',
                'tanggal_lahir' => '2017-12-03',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'pendidikan_sebelumnya' => 'TK IMTAQ Mojokerto',
                'alamat_siswa' => 'Trenggilis RT 01 RW 02 Kel. Blooto Kota Mojokerto',
                'nama_ayah' => 'Muhammad Fanani, SE',
                'pekerjaan_ayah' => 'Karyawan Swasta',
                'nama_ibu' => 'Maria Bunga Yuspitasari, S.Pd',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'alamat_ortu' => 'Trenggilis RT 001 RW 002',
                'no_wa_ortu' => '089608972661',
            ],
            [
                'nisn' => '3186385878',
                'nama' => 'Hanifa Hayatul Fitra',
                'nama_panggilan' => 'Hani',
                'tempat_lahir' => 'Mojokerto',
                'tanggal_lahir' => '2018-06-14',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'pendidikan_sebelumnya' => 'TK NU Kota Sorong Papua',
                'alamat_siswa' => 'Perum. Star Residen 1 Sambiroto Kec. Sooko Kab. Mojokerto',
                'nama_ayah' => 'Yoyok Hariyanto',
                'pekerjaan_ayah' => 'POLRI',
                'nama_ibu' => 'Suaibatul Islamiyah',
                'pekerjaan_ibu' => 'Guru',
                'alamat_ortu' => 'Perum Star 1',
                'no_wa_ortu' => '089608972661',
            ],
        ];

        foreach ($siswas as $index => $siswaData) {
            // Menambahkan status siswa
            $siswaData['status'] = 'calon';
            
            // Menghitung nomor pendaftaran
            // Menggunakan str_pad untuk format 4 digit dengan leading zeros
            $nomor_urut = str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            $siswaData['no_pendaftaran'] = 'PPDB-2025-' . $nomor_urut;

            // Gunakan firstOrCreate untuk menghindari duplikasi data berdasarkan NISN
            Siswa::firstOrCreate(
                ['nisn' => $siswaData['nisn']],
                $siswaData
            );
        }
    }
}