<?php 
Class Admin_Model extends CI_Model {
	public function login($username, $password_hash) {
		$condition	= "username="."'".$username."'". " AND "."password="."'".$password_hash."'";
		$select		= array('username', 'password');
		$this->db->select($select);
		$this->db->from('tb_admin');
		$this->db->where($condition);
		$login 		= $this->db->get();
		
		if($login->num_rows() > 0) {
			return true;
		}
		else {
			return false;
		}
	}
	public function cekelas() {
		$cek = $this->db->query("SELECT * FROM tb_kelas");
		if($cek->num_rows() > 0) {
			return true;
		}
		else {
			return false;
		}
	}
	public function regvalid() {
		$load = $this->db->query("SELECT * FROM tb_identitassekolah");
		if($load->num_rows() > 0) {
			return true;
		}
		else {
			return false;
		}
	}
	public function regsekolah($npsn,$nm_sekolah) {
		$data				= array(
			'npsn'			=> $npsn,
			'nm_sekolah'	=> $nm_sekolah
		);
		$this->db->insert('tb_identitassekolah', $data);
	}
	public function dataadmin() {
		$load = $this->db->query('SELECT * FROM tb_admin');
		return $load->result_array();
	}
	public function gantipassword($username, $password_hash) {
		$update = $this->db->query("UPDATE tb_admin SET password='$password_hash' WHERE username='$username'");
		return $update;
	}
	public function datapilketos() {
		$load = $this->db->query("SELECT * FROM tb_datapilketos WHERE id='1'");
		return $load->result_array();
	}
	public function updatedatapilketos($tapel, $tgl){
		$update = $this->db->query("UPDATE tb_datapilketos SET tapel='$tapel', tgl='$tgl' WHERE id='1'");
		return $update;
	}
	public function resetuser($username) {
		$reset = $this->db->query("DELETE FROM tb_pilih WHERE username='$username'");
		return $reset;
	}
	public function updateuser($username) {
		$reset = $this->db->query("UPDATE tb_siswa SET hadir='Tidak Hadir' WHERE username='$username'");
		return $reset;
	}
	public function resetdata(){
		$reset 	= $this->db->query("DELETE FROM tb_pilih");
		$reset1	= $this->db->query("DELETE FROM tb_siswa");
		$reset2	= $this->db->query("DELETE FROM tb_pilihan");
		$reset3	= $this->db->query("DELETE FROM tb_siswa");
		$reset4	= $this->db->query("UPDATE tb_datapilketos SET tapel='', tgl='' WHERE id='1'");
		return true;
	}
	public function idsekolah() {
		$load = $this->db->query("SELECT * FROM tb_identitassekolah");
		return $load->result_array();
	}
	public function updateidsekolah($npsn, $nm_sekolah, $jln, $desa, $kec, $kab, $kpl_sekolah, $nip){
		$save = $this->db->query("UPDATE tb_identitassekolah SET npsn='$npsn', nm_sekolah='$nm_sekolah', jln='$jln', desa='$desa', kec='$kec', kab='$kab', kpl_sekolah='$kpl_sekolah', nip='$nip'");
		return $save;
	}
	public function datakelas() {
		$load = $this->db->query("SELECT * FROM tb_kelas");
		return $load->result_array();
	}
	public function simpankelas($nm_kelas) {
		$data = array(
			'nm_kelas'	=> $nm_kelas
		);
		$this->db->insert('tb_kelas', $data);
	}
	public function tambahcalon($nisn, $no , $nama, $photo) {
		$data		= array (
			'nisn'	=> $nisn,
			'no'	=> $no,
			'nama'	=> $nama,
			'photo' => $photo
		);
		$this->db->insert('tb_pilihan', $data);
	}
	public function hapuskelas($kd_kelas) {
		$hapus = $this->db->query("DELETE FROM tb_kelas WHERE kd_kelas='$kd_kelas'");
		return $hapus;
	}
	public function hapussemuakelas() {
		$hapus = $this->db->query("DELETE FROM tb_kelas");
		return $hapus;
	}
	public function updatecalon($nisn, $no , $nama) {
		$save		= $this->db->query("UPDATE tb_pilihan SET no='$no', nama='$nama' WHERE nisn='$nisn'");
		return $save;
	}
	public function hapuscalon($nisn) {
		$hapus		= $this->db->query("DELETE FROM tb_pilihan WHERE nisn='$nisn'");
		return $hapus;
	}
	public function datacalon() {
		$load	= $this->db->query("SELECT * FROM tb_pilihan ORDER BY no asc");
		return $load->result_array();
	}
	public function datadpt() {
		$load = $this->db->query("SELECT * FROM tb_siswa INNER JOIN tb_kelas ON tb_kelas.kd_kelas = tb_siswa.kd_kelas ORDER BY tb_siswa.kd_kelas asc");
		return $load->result_array();
	}
	public function datakddpt($username) {
		$load = $this->db->query("SELECT * FROM tb_siswa INNER JOIN tb_kelas ON tb_kelas.kd_kelas = tb_siswa.kd_kelas WHERE tb_siswa.username='$username'");
		return $load->result_array();
	}
	public function simpandpt($username, $password, $nm_siswa, $jk,$kd_kelas) {
		$data 			= array(
			'username'	=> $username,
			'password'	=> $password,
			'nm_siswa'	=> $nm_siswa,
			'jk'		=> $jk,
			'kd_kelas'	=> $kd_kelas
		);
		$this->db->insert('tb_siswa', $data);
	}
	public function simpanmassaldpt($nisn, $nama, $jk, $kelas) {
		$data			= array(
			'username'	=> $nisn,
			'password'	=> $nisn,
			'nm_siswa'	=> $nama,
			'jk'		=> $jk,
			'kd_kelas'	=> $kelas
		);
		$this->db->insert('tb_siswa', $data);
	}
	public function hapusdpt($username) {
		$hapus	= $this->db->query("DELETE FROM tb_siswa WHERE username='$username'");
		return $hapus;
	}
	public function hapussemuadpt() {
		$hapus	= $this->db->query("DELETE FROM tb_siswa");
		return $hapus;
	}
	public function updatedpt($username, $nm_siswa, $jk,$kd_kelas) {
		$update = $this->db->query("UPDATE tb_siswa SET nm_siswa='$nm_siswa', jk='$jk', kd_kelas='$kd_kelas' WHERE username='$username'");
		return $update;
	}
	public function datacalonspesifik($nisn) {
		$load	= $this->db->query("SELECT * FROM tb_pilihan WHERE nisn='$nisn'");
		return $load->result_array();
	}
	public function countcalon() {
		$count	= $this->db->query("SELECT COUNT(no) AS jumlah FROM tb_pilihan");
		return $count->result_array();
	}
	public function countpemilih() {
		$count	= $this->db->query("SELECT COUNT(username) AS jumlah FROM tb_siswa");
		return $count->result_array();
	}
	public function countvote() {
		$count	= $this->db->query("SELECT COUNT(username) AS jumlah FROM view_vote");
		return $count->result_array();
	}
	public function hasilvote() {
		$count	= $this->db->query("SELECT * , (
		SELECT COUNT(tb_pilih.id_pilih)) AS jumlah
		FROM
		tb_pilihan
		INNER JOIN tb_pilih
		ON
		tb_pilihan.nisn = tb_pilih.nisn
		INNER JOIN tb_siswa
		ON 
		tb_siswa.username = tb_pilih.username
		GROUP BY tb_pilih.nisn
		ORDER BY tb_pilihan.no ASC
		");
		return $count->result_array();
	}
	public function jmldptL() {
		$data = $this->db->query("SELECT COUNT(jk) as L FROM tb_siswa WHERE jk='L'");
		return $data->result_array();
	}
	public function jmldptP() {
		$data = $this->db->query("SELECT COUNT(jk) as P FROM tb_siswa WHERE jk='P'");
		return $data->result_array();
	}
	public function jmlvoteL() {
		$data = $this->db->query("
		SELECT COUNT(tb_siswa.jk) as L 
		FROM 
		tb_siswa 
		INNER JOIN 
		tb_pilih
		ON 
		tb_siswa.username = tb_pilih.username
		WHERE jk='L'");
		return $data->result_array();
	}
	public function jmlvoteP() {
		$data = $this->db->query("
		SELECT COUNT(tb_siswa.jk) as P 
		FROM 
		tb_siswa 
		INNER JOIN 
		tb_pilih
		ON 
		tb_siswa.username = tb_pilih.username
		WHERE jk='P'");
		return $data->result_array();
	}
	public function kuncivote() {
		$data	= $this->db->query("SELECT * FROM tb_pilih");
		return $data->result_array();
	}
	public function daftarhadir() {
		$data	= $this->db->query("SELECT * FROM tb_siswa INNER JOIN tb_kelas ON tb_kelas.kd_kelas = tb_siswa.kd_kelas ORDER BY tb_kelas.kd_kelas ASC");
		return $data->result_array();
	}
}
?>