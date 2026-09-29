# E-Pilketos

Aplikasi pemilihan Ketua OSIS ini menggunakan CodeIgniter 3 dan MySQL/MariaDB. Halaman utama menampilkan status pemilihan dan kandidat; pemilih masuk dengan akun DPT dan setiap akun hanya dapat memberikan satu suara. Panitia mengelola informasi sekolah, periode/status, kandidat, foto, visi-misi, dan hasil melalui panel admin.

## Persyaratan

- PHP 7.4 atau lebih baru, dengan ekstensi `mysqli`, `mbstring`, `fileinfo`, dan `openssl`.
- MySQL 5.7+ atau MariaDB 10.3+.
- Apache dengan `mod_rewrite` bila URL tanpa `index.php` diperlukan; aplikasi tetap dapat dijalankan dengan `index.php` di URL.
- Direktori `uploads/candidates/` harus dapat ditulis oleh user web server.

## Instalasi lokal

1. Buat database kosong bernama `db_pilketos`, lalu import `db_pilketos.sql`.
2. Atur koneksi database melalui environment. Untuk sesi PowerShell lokal:

   ```powershell
   $env:PILKETOS_DB_HOST = "localhost"
   $env:PILKETOS_DB_USER = "root"
   $env:PILKETOS_DB_PASSWORD = ""
   $env:PILKETOS_DB_NAME = "db_pilketos"
   $env:PILKETOS_BASE_URL = "http://localhost/pilketos/"
   ```

   Nilai lokal di atas hanya contoh untuk instalasi XAMPP. Pada hosting/produksi, atur environment variable melalui pengelola environment hosting dan gunakan akun database khusus dengan hak minimum serta password unik. Jangan menyimpan rahasia produksi di repository.
3. Dari root proyek, jalankan migrasi sekali:

   ```powershell
   php index.php migrate current
   ```

   Migrasi menambahkan status dan periode pemilihan, visi-misi kandidat, hash password yang lebih panjang, serta batas satu suara per pemilih dan nomor urut kandidat. Migrasi berhenti tanpa menghapus data apabila menemukan suara ganda untuk pemilih atau nomor urut kandidat yang duplikat. Cadangkan database sebelum migrasi dan tinjau duplikasi tersebut secara manual sebelum mencoba kembali.
4. Buat akun admin pertama melalui terminal server:

   ```powershell
   php index.php admin create_admin panitia
   ```

   Aplikasi membuat password acak satu kali dan menampilkannya di terminal. Simpan di password manager; tidak ada username/password admin bawaan dan pembuatan akun awal tidak tersedia melalui web. Setelah login, password dapat diganti dari panel admin.
5. Akses `http://localhost/pilketos/` untuk halaman publik. Panel admin tersedia di `http://localhost/pilketos/index.php/admin/login`; pemilih masuk dari tombol “Masuk untuk memilih”.

Jika domain atau direktori instalasi berbeda, set `PILKETOS_BASE_URL` dengan URL lengkap yang diakhiri `/`. Agar cookie sesi hanya dikirim melalui HTTPS, set `PILKETOS_COOKIE_SECURE=1` setelah HTTPS aktif.

## Pengelolaan pemilihan

- Panel `/admin/election` menyimpan status draft/dibuka/ditutup, informasi, tahun pelajaran, tanggal dan periode, identitas sekolah, visibilitas hasil, serta data kandidat.
- Pemungutan suara hanya diterima ketika status dibuka dan waktu periode mengizinkan. Identitas pemilih diambil dari sesi login, bukan dari kolom tersembunyi pada formulir.
- Kandidat dikunci setelah suara pertama masuk untuk menjaga integritas hasil. Kandidat yang sudah memperoleh suara tidak dapat dihapus.
- Hasil publik hanya ditampilkan ketika pemilihan ditutup dan opsi publik hasil diaktifkan.
- Password DPT lama bermigrasi ke hash ketika berhasil login. Akun dengan password awal yang sama dengan NISN wajib menggantinya (minimal 12 karakter) sebelum dapat memilih. Akun DPT yang ditambahkan melalui formulir/impor lama juga ditandai untuk mengganti password awal.

## Migrasi dan deployment

Sebelum online, pasang aplikasi dan database pada hosting PHP/MySQL yang mendukung versi di atas, atur environment variable, jalankan migrasi dari CLI, buat akun admin melalui CLI, aktifkan HTTPS, dan pastikan direktori unggahan tidak dapat mengeksekusi skrip. Jangan membuka aplikasi untuk pemilihan sebelum daftar DPT, akun pemilih, kandidat, dan status/periode telah diverifikasi panitia.

Repository ini tidak menyediakan konfigurasi provisioning atau pipeline deployment; petunjuk ini tidak berarti aplikasi telah di-deploy atau di-hosting. Selalu simpan backup database dan file foto sesuai kebijakan sekolah.
