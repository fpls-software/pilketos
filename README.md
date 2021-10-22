# DAFTAR PERUBAHAN
<ol>
  <li>Penambahan Fitur Tambah Massal Data DPT</li>
  <li>Penambahan Fitur Hapus Semua Data Kelas</li>
  <li>Penambahan Fitur Hapus Semua Data DPT</li>
  <li>Penambahan Fitur Konfirmasi Sebelum Melakukan Penghapusan Data</li>
</ol>

# E-pilketos
E-Pilketos adalah aplikasi E-Voting untuk Pemilihan Ketua Osis. Aplikasi ini dikembangkan untuk membantu Sekolah-Sekolah dalam melakukan Pemilihan Ketua OSIS dengan Mudah dan Cepat. 
Aplikasi ini adalah aplikasi yang gratis untuk digunakan, namun jika anda ingin memberikan Kontribusi atau membantu Kami untuk pengembangan Aplikasi ini lebih lanjut anda dapat memberika Donasi kepada Kami Seikhlasnya.

# Fitur
<ol>
  <li><b>Reset Data</b> (Fitur ini diperlukan pada saat Sekolah ingin membersihkan data pada database dan ingin melakukan Pemilihan pada tahnu berikutnya</li>
  <li><b>Kunci Akun</b> (Fitur ini menonaktifkan akun DPT pada saat dia selesai melakukan pemilihan jadi dia tidak akan punya kesempatan untuk memilih lebih dari 1 kali</li>
  <li><b>Reset User</b> (Fitur ini digunakan apabila ada DPT yang mengajukan komplain bahwa dia belum pernah melakukan Pemilihan namun akunnya telah terkunci</li>
  <li><b>Data Sekolah</b> (Dengan fitur ini anda bisa memperbarui data sekolah anda</li>
  <li><b>Data Kelas DPT</b> (Dengan fitur ini anda bisa menambahkan kelas atau menghapus kelas yang sudah ada)</li>
  <li><b>Data Kandidat</b> (Dengan fitur ini anda bisa Menambahkan atau menghapus Kandidat Ketua OSIS)</li>
  <li><b>Data DPT</b> (Dengan fitur ini anda bisa Menambahkan atau menghapus Daftar Pemilih Tetap)</li>
  <li><b>Hasil Pemilihan</b> (Dengan fitur ini anda dapat melihat hasil pemilihan Ketua OSIS)</li>
  <li><b>Daftar Hadir</b> (Dengan Fitur ini anda dapat Mengunduh Daftar Hadir Pemilihan Ketua OSIS)</li>
  <li><b>Laporan Pilketos</b> (Dengan Fitur ini anda dapat Mengunduh Laporan Pemilihan Ketua OSIS)</li>
</ol>

# User Guide
<h2>Local Instalation</h2>
<ol>
	<li>Download XAMPP <a href="https://www.apachefriends.org/download.html" target="_blank">Disini</a> dan install</li>
	<li>Jalankan XAMPP Control Panel dan Klik Start(Mulai) pada <b>Apache</b> dan <b>Mysql</b></li>
	<li>Copy File <b>pilketos-master.zip</b> ke Folder <b>C://xampp/htdocs/</b> Kemudian Extract</li>
</ol>
<br/>
<h2>Creating Database</h2>
<ol>
	<li>Masuk ke Browser kemudian tulis di Address Bar http://localhost/phpmyadmin</li>
	<li>Buat Database dengan Nama <b>db_pilketos</b></li>
	<li>Import Database <b>db_pilketos.sql</b> <a href="https://www.domainesia.com/panduan/cara-import-database-mysql-di-phpmyadmin/" target="_blank">Tutorial Disini</a></li>
</ol>
<br/>
<h2>Pilketos Konfiguration</h2>
<b>Konfigurasi Database</b>
<ul>
	<li>Edit File <b>database.php</b> yang ada pada Folder <b>application/config/</b></li>
	<li>Kemudian Pastikan <b>Hostname</b>nya Bernilai <b>localhost</b></li>
	<li><b>Username</b> bernilai <b>root</b></li>
	<li><b>Password</b> dibiarkan <b>kosong</b></li>
	<li>dan <b>Database</b> bernilai <b>db_pilketos</b> <b>Note: <i>Sesuaikan dengan nama database yang Dibuat Tadi</i></b></li>
	<li>Simpan File</li>
		
</ul>
<b>Konfigurasi Base URL</b>
<ul>
	<li>Edit File <b>config.php</b> yang ada pada Folder <b>application/config/</b></li>
	<li>Kemudian pastikan <b>variable $config['base_url']</b> bernilai <b>'http://localhost/pilketos/</b></li>
	<li>Simpan File</li>
</ul>
<br/>
<h2>Akses Aplikasi</h2>
<b>Akses Admin</b>
<ul> 
	<li>Masuk ke Browser kemudian tulis di address bar <b>http://localhost/pilketos/index.php/admin/</b></li>
	<li>Login dengan menggunakan <b>Username = admin</b> dan <b>Password = admin</b></li> 
</ul>
<b>Akses User (DPT)</b>
<ul> 
	<li>Masuk Ke Browser kemudian tulis di address bar <b>http://localhost/pilketos</b></li>
	<li>Login dengan menggunakan <b>Username dan Password = NISN</b> DPT yang bersangkutan, yang telah di INPUT oleh Admin sebelumnya</li>
</ul>




 
