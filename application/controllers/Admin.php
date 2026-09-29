 <?php 
Class Admin extends CI_Controller {
	public function __construct() 
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form','url'));
		$this->load->library(array('session', 'pdflibrary', 'Excelreaders'));
		$this->load->model(array('Admin_Model'));
		$method = $this->uri->segment(2) ? $this->uri->segment(2) : 'index';
		if ($method === 'create_admin' && $this->input->is_cli_request()) {
			return;
		}
		if ($method === 'create_admin') {
			show_error('This command can only be run from the command line.', 403);
		}
		if (!in_array($method, array('login', 'loginvalidation'), TRUE)
			&& $this->session->userdata('role') !== 'admin') {
			redirect('admin/login');
		}
		if ($this->session->userdata('role') === 'admin'
			&& $this->Admin_Model->must_change_admin_password($this->session->userdata('username'))
			&& !in_array($method, array('gantipassword', 'updatepassword', 'logout'), TRUE)) {
			redirect('admin/gantipassword');
		}
		$read_only = array(
			'login', 'logout', 'regvalid', 'regsekolah', 'index', 'gantipassword', 'idsekolah',
			'datakelas', 'tambahcalon', 'tambahdpt', 'datadpt', 'editdpt',
			'editcalon', 'datacalon', 'hasilvote', 'daftarhadir', 'tgl_indo',
			'cetakdaftarhadir', 'laporan', 'election'
		);
		if (!in_array($method, $read_only, TRUE)
			&& strtoupper($this->input->method(TRUE)) !== 'POST') {
			show_error('This action requires a POST request.', 405);
		}
	}
	public function login() {
		if($this->session->userdata('role') === 'admin')
		{
			redirect('admin/election');
		}
		if ($this->Election_Model->candidate_number_exists((int) $number, $editing ? $nisn : NULL)) {
			$this->session->set_flashdata('error', 'Nomor urut tersebut sudah digunakan kandidat lain.');
			redirect('admin/election');
		}
		$data['admin_count'] = $this->Admin_Model->admin_count();
		$this->load->view('admin/login', $data);
	}
	public function gantipassword() {
		$data['dataadmin'] = array(array('username' => $this->session->userdata('username')));
		$this->load->view('admin/head');
		$this->load->view('admin/admin-navbar');
		$this->load->view('admin/gantipassword', $data);
		$this->load->view('admin/footer', $data);
	}
	public function updatepassword() {
		$username		= $this->session->userdata('username');
		$current_password = (string) $this->input->post('current_password');
		$password		= (string) $this->input->post('password');
		if (!$this->Admin_Model->authenticate($username, $current_password)) {
			$this->session->set_flashdata('updatefailed', 'Password saat ini tidak sesuai.');
			redirect('admin/gantipassword');
		}
		if (strlen($password) < 12) {
			$this->session->set_flashdata('updatefailed', 'Password baru minimal 12 karakter.');
			redirect('admin/gantipassword');
		}
		$password_hash	= password_hash($password, PASSWORD_DEFAULT);
		$update			= $this->Admin_Model->change_admin_password($username, $password_hash);
		if($update) {
			$this->session->set_flashdata('update', 'Berhasil Memperbarui Password');
			redirect('admin/gantipassword');
		}
		else {
			$this->session->set_flashdata('updatefailed', 'Gagal Memperbarui Password');
			redirect('admin/gantipassword');
		}
	}
	public function logout() {
		$this->session->sess_destroy();
		redirect('admin/login');
	}
	public function loginvalidation() {
		if (strtoupper($this->input->method(TRUE)) !== 'POST') {
			show_error('This action requires a POST request.', 405);
		}
		$username				= $this->input->post('username', TRUE);
		$password				= (string) $this->input->post('password');
		$result					= $this->Admin_Model->authenticate($username, $password);
		if($result == true) {
			$this->session->sess_regenerate(TRUE);
			$this->session->set_userdata(array(
				'username'	=> $username,
				'role'		=> 'admin'
			));
			redirect('admin/regvalid');
		}
		else
		{
			$this->session->set_flashdata('failed', 'Username atau Password Salah');
			redirect('admin/login');
		}
	}
	public function regvalid(){
		$data = $this->Admin_Model->idsekolah();
		if (!$data || empty($data[0]['npsn'])) {
			redirect('admin/regsekolah');
		}
		else {
			redirect('admin/election');
		}
	}
	public function regsekolah() {
		$data = $this->Admin_Model->regvalid();
		if($data == true) {
			redirect('admin/index');
		}
		$this->load->view('admin/head');
		$this->load->view('admin/regsekolah');
	}
	public function simpansekolah() {
		$npsn		= $this->input->post('npsn');
		$nm_sekolah	= $this->input->post('nm_sekolah');
		$reg		= $this->Admin_Model->regsekolah($npsn,$nm_sekolah);
		if($reg = true) {
			redirect('admin/index');
		}
		else {
			$this->session->set_flashdata('regfailed', 'Registrasi Gagal');
			redirect('admin/regsekolah');
		}
	}
	public function index() {
		redirect('admin/election');
	}
	public function updatedatapilketos(){
		$tapel	= $this->input->post("tapel");
		$tgl	= $this->input->post('tgl');
		$update = $this->Admin_Model->updatedatapilketos($tapel, $tgl);
		if($update = true) {
			$updateuser	= $this->Admin_Model->updateuser($username);
			$this->session->set_flashdata('update', 'Berhasil Menyimpan Data');
			redirect('admin/index');
		}
		else {
			$this->session->set_flashdata('updatefailed', 'Gagal Menyimpan User');
			redirect('admin/index');
		}
	}
	public function resetuser() {
		$username	= $this->input->post('username');
		$reset		= $this->Admin_Model->resetuser($username);
		if($reset = true) {
			$updateuser	= $this->Admin_Model->updateuser($username);
			$this->session->set_flashdata('info', 'Berhasil Mereset User');
			redirect('admin/index');
		}
		else {
			$this->session->set_flashdata('failed', 'Gagal Mereset User');
			redirect('admin/index');
		}
		
	}
	public function resetdata() {
		$reset = $this->Admin_Model->resetdata();
		if($reset = true) {
			$this->session->set_flashdata('reset', 'Berhasil Mereset Data');
			redirect('admin/index');
		}
		else {
			$this->session->set_flashdata('resetfailed', 'Gagal Mereset Data');
			redirect('admin/index');
		}
	}
	public function idsekolah() {
		if(! $this->session->userdata('username'))
		{
			redirect('admin/login');
		}
		$data['valid'] = $this->Admin_Model->regvalid();
		if(! $data['valid'] == true) {
			redirect('admin/regsekolah');
		}
		$data['idsekolah']	= $this->Admin_Model->idsekolah();
		$this->load->view('admin/head');
		$this->load->view('admin/admin-navbar');
		$this->load->view('admin/idsekolah', $data);
		$this->load->view('admin/footer', $data);
	}
	public function updateidsekolah() {
		$npsn			= $this->input->post('npsn');
		$nm_sekolah		= $this->input->post('nm_sekolah');
		$jln			= $this->input->post('jln');
		$desa			= $this->input->post('desa');
		$kec			= $this->input->post('kec');
		$kab			= $this->input->post('kab');
		$kpl_sekolah	= $this->input->post('kpl_sekolah');
		$nip			= $this->input->post('nip');
		$save			= $this->Admin_Model->updateidsekolah($npsn, $nm_sekolah, $jln, $desa, $kec, $kab, $kpl_sekolah, $nip);
		if($save = true) {
			$this->session->set_flashdata('info', 'Berhasil Memperbarui Data');
			redirect('admin/idsekolah');
		}
		else 
		{
			$this->session->set_flashdata('failed', 'Gagal Memperbarui Data');
			redirect('admin/idsekolah');
		}
	}
	public function datakelas() {
		if(! $this->session->userdata('username'))
		{
			redirect('admin/login');
		}
		$data['idsekolah']	= $this->Admin_Model->idsekolah();
		$data['datakelas']	= $this->Admin_Model->datakelas();
		$this->load->view('admin/head');
		$this->load->view('admin/admin-navbar');
		$this->load->view('admin/datakelas', $data);
		$this->load->view('admin/footer', $data);
	}
	public function simpankelas() {
		$nm_kelas	= $this->input->post('nm_kelas');
		$save		= $this->Admin_Model->simpankelas($nm_kelas);
		if($save = true) {
			$this->session->set_flashdata('info', 'Berhasil Menambahkan Data');
			redirect('admin/datakelas');
		}
		else 
		{
			$this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
			redirect('admin/datakelas');
		}
	}
	public function hapuskelas($kd_kelas) {
		$hapus = $this->Admin_Model->hapuskelas($kd_kelas);
		if($hapus) {
			$this->session->set_flashdata('info', 'Berhasil Menghapus Data');
			redirect('admin/datakelas');
		}
		else 
		{
			$this->session->set_flashdata('failed', 'Gagal Menghapus Data');
			redirect('admin/datakelas');
		}
	}
	public function hapussemuakelas() {
		$hapus = $this->Admin_Model->hapussemuakelas();
		if($hapus = true) {
			echo "
				<script>
					alert('Semua Data Kelas Telah Dihapus');
					location.href = '".base_url('index.php/admin/datakelas')."';
				</script>
			";
		}
		else 
		{
			echo "
				<script>
					Alert('Tidak Dapat Menghapus Semua Data');
					location.href = '".base_url('index.php/admin/datakelas')."';
				</script>
			";
		}
	}
	public function tambahcalon() {
		if(! $this->session->userdata('username'))
		{
			redirect('admin/login');
		}
		$data['idsekolah']	= $this->Admin_Model->idsekolah();
		$this->load->view('admin/head');
		$this->load->view('admin/admin-navbar');
		$this->load->view('admin/tambahcalon');
		$this->load->view('admin/footer', $data);
	}
	public function hapuscalon($nisn) {
		if ($this->_candidate_updates_locked()) {
			$this->session->set_flashdata('failed', 'Kandidat tidak dapat diubah setelah suara tercatat.');
			redirect('admin/datacalon');
		}
		$this->load->model('Election_Model');
		$hapus = $this->Election_Model->delete_candidate($nisn);
		if($hapus) {
			$this->session->set_flashdata('info', 'Berhasil Menghapus Data');
			redirect('admin/datacalon/');
		}
		else 
		{
			$this->session->set_flashdata('failed', 'Gagal Menghapus Data');
			redirect('admin/datacalon/');
		}
	}
	public function tambahdpt() {
		if(! $this->session->userdata('username'))
		{
			redirect('admin/login');
		}
		$cekelas			= $this->Admin_Model->cekelas();
		if($cekelas == false) {
			echo "
				<script>
					alert('Anda Belum Menambahan Data Kelas, Silahkan Ditambahkan Terlebih Dahulu.');
					location.href = '".base_url('index.php/admin/datakelas')."';
				</script>
			";
		}
		$data['idsekolah']	= $this->Admin_Model->idsekolah();
		$data['datakelas']	= $this->Admin_Model->datakelas();
		$this->load->view('admin/head');
		$this->load->view('admin/admin-navbar');
		$this->load->view('admin/tambahdpt', $data);
		$this->load->view('admin/footer', $data);
	}
	public function datadpt() {
		if(! $this->session->userdata('username'))
		{
			redirect('admin/login');
		}
		$data['idsekolah']	= $this->Admin_Model->idsekolah();
		$data['datadpt']	= $this->Admin_Model->datadpt();
		$this->load->view('admin/head');
		$this->load->view('admin/admin-navbar');
		$this->load->view('admin/datadpt', $data);
		$this->load->view('admin/footer', $data);
	}
	public function simpandpt() {
		$username	= $this->input->post('nisn');
		$password	= $this->input->post('nisn');
		$nm_siswa	= $this->input->post('nm_siswa');
		$jk 		= $this->input->post('jk');
		$kd_kelas	= $this->input->post('kd_kelas');
		$save 		= $this->Admin_Model->simpandpt($username, $password, $nm_siswa, $jk ,$kd_kelas);
		if($save = true) {
			$this->session->set_flashdata('info', 'Berhasil MemperbaruiData');
			redirect('admin/tambahdpt/');
		}
		else 
		{
			$this->session->set_flashdata('failed', 'Gagal Memperbarui Data');
			redirect('admin/tambahdpt/');
		}
	}
	public function simpanmassaldpt() {
		$target = basename($_FILES['datadpt']['name']) ;
		move_uploaded_file($_FILES['datadpt']['tmp_name'], $target);
		
		// beri permisi agar file xls dapat di baca
		chmod($_FILES['datadpt']['name'],0777);
		
		// mengambil isi file xls
		$data = new Spreadsheet_Excel_Reader($_FILES['datadpt']['name'], false);
		// menghitung jumlah baris data yang ada
		$jumlah_baris = $data->rowcount($sheet_index=0);
		
		// jumlah default data yang berhasil di import
		$berhasil = 0;
		for ($i=2; $i<=$jumlah_baris; $i++){
			$nisn	= $data->val($i, 2);
			$nama	= $data->val($i, 3);
			$jk		= $data->val($i, 4);
			$kelas	= $data->val($i, 5);
			if($nisn != "" && $nama != "" && $jk != "" && $kelas != "") {
				$simpan = $this->Admin_Model->simpanmassaldpt($nisn, $nama, $jk, $kelas);
				$berhasil++;
				
			}
		}
		if($simpan = true) {
			$this->session->set_flashdata('info', 'Berhasil Menambahkan Data');
			redirect('admin/tambahdpt/');
		}
		else {
			$this->session->set_flashdata('failed', 'Tidak Dapat Menambahkan Data');
			redirect('admin/tambahdpt/');
		}
		unlink($_FILES['datadpt']['name']);
	}
	public function hapusdpt($username) {
		$hapus	= $this->Admin_Model->hapusdpt($username);
		if($hapus = true) {
			$this->session->set_flashdata('info', 'Berhasil Menghapus Data');
			redirect('admin/datadpt/');
		}
		else 
		{
			$this->session->set_flashdata('failed', 'Berhasil Menghapus Data');
			redirect('admin/datadpt/');
		}
	}
	public function hapussemuadpt() {
		$hapus = $this->Admin_Model->hapussemuadpt();
		if($hapus = true) {
			echo "
				<script>
					alert('Semua Data Kelas Telah Dihapus');
					location.href = '".base_url('index.php/admin/datadpt')."';
				</script>
			";
		}
		else 
		{
			echo "
				<script>
					Alert('Tidak Dapat Menghapus Semua Data');
					location.href = '".base_url('index.php/admin/datadpt')."';
				</script>
			";
		}
	}
	public function editdpt($username) {
		$data['datakddpt']	= $this->Admin_Model->datakddpt($username);
		$data['datakelas']	= $this->Admin_Model->datakelas();
		$data['idsekolah']	= $this->Admin_Model->idsekolah();
		$this->load->view('admin/head');
		$this->load->view('admin/admin-navbar');
		$this->load->view('admin/editdpt', $data);
		$this->load->view('admin/footer', $data);
	}
	public function updatedpt($username){
		$username	= $this->input->post('nisn');
		$nm_siswa	= $this->input->post('nm_siswa');
		$jk			= $this->input->post('jk');
		$kd_kelas	= $this->input->post('kd_kelas');
		$update		= $this->Admin_Model->updatedpt($username, $nm_siswa, $jk,$kd_kelas);
		if($update = true) {
			$this->session->set_flashdata('info', 'Berhasil Mengupdate Data');
			redirect('admin/editdpt/'.$username);
		}
		else 
		{
			$this->session->set_flashdata('failed', 'Gagal Mengupdate Data');
			redirect('admin/editdpt/'.$username);
		}
	}

	public function editcalon($nisn) {
		$data['datacalon']	= $this->Admin_Model->datacalonspesifik($nisn);
		$data['idsekolah']	= $this->Admin_Model->idsekolah();
		$this->load->view('admin/head');
		$this->load->view('admin/admin-navbar');
		$this->load->view('admin/editcalon', $data);
		$this->load->view('admin/footer', $data);
	}
	public function simpancalon() {
		if ($this->_candidate_updates_locked()) {
			$this->session->set_flashdata('failed', 'Kandidat tidak dapat diubah setelah suara tercatat.');
			redirect('admin/tambahcalon');
		}
		$nisn		= $this->input->post('nisn');
		$no			= $this->input->post('no');
		$nama		= $this->input->post('nama');
		$this->load->model('Election_Model');
		if (!$nisn || strlen($nisn) > 32 || !preg_match('/^[A-Za-z0-9._-]+$/', $nisn)
			|| !$nama || strlen($nama) > 32 || !ctype_digit((string) $no)
			|| (int) $no < 1 || (int) $no > 99
			|| $this->Election_Model->candidate_number_exists((int) $no)) {
			$this->session->set_flashdata('failed', 'Data kandidat tidak valid atau nomor urut telah digunakan.');
			redirect('admin/tambahcalon');
		}
		$config['upload_path']	= "./asset/img/";
		$config['allowed_types']= "gif|jpg|jpeg|png";
		$config['max_size']		= 1024;
		$config['file_name']	= $nisn;
		$this->load->library('upload', $config);
		if($this->upload->do_upload('photo'))
		{
			$data['upload_data']= $this->upload->data();
			$photo				= $data['upload_data']['file_name'];
			$saved = $this->Election_Model->add_candidate(array(
				'nisn' => $nisn,
				'no' => (int) $no,
				'nama' => $nama,
				'photo' => $photo
			));
			if (!$saved) {
				$uploaded_path = $data['upload_data']['full_path'];
				if (is_file($uploaded_path)) {
					unlink($uploaded_path);
				}
				$this->session->set_flashdata('failed', 'Gagal menambahkan kandidat.');
				redirect('admin/tambahcalon');
			}
			$this->session->set_flashdata('info', 'Berhasil Menambahkan Data');
			redirect('admin/tambahcalon');
		}
		else 
		{
			$this->session->set_flashdata('failed', 'Gagal Menambahkan Data');
			redirect('admin/tambahcalon');
		}
	}
	public function updatecalon() {
		if ($this->_candidate_updates_locked()) {
			$this->session->set_flashdata('failed', 'Kandidat tidak dapat diubah setelah suara tercatat.');
			redirect('admin/datacalon');
		}
		$nisn		= $this->input->post('nisn');
		$no			= $this->input->post('no');
		$nama		= $this->input->post('nama');
		$this->load->model('Election_Model');
		$update = ctype_digit((string) $no) && (int) $no > 0 && (int) $no <= 99
			&& $nama && strlen((string) $nama) <= 32
			&& !$this->Election_Model->candidate_number_exists((int) $no, $nisn)
			&& $this->Election_Model->update_candidate($nisn, array('no' => (int) $no, 'nama' => $nama));
		if($update) {
			$this->session->set_flashdata('info', 'Berhasil MemperbaruiData');
			redirect('admin/editcalon/'.$nisn);
		}
		else 
		{
			$this->session->set_flashdata('failed', 'Gagal Memperbarui Data');
			redirect('admin/editcalon/'.$nisn);
		}
	}
	public function datacalon() {
		if(! $this->session->userdata('username'))
		{
			redirect('admin/login');
		}
		$data['datacalon']	= $this->Admin_Model->datacalon();
		$data['idsekolah']	= $this->Admin_Model->idsekolah();
		$this->load->view('admin/head');
		$this->load->view('admin/admin-navbar');
		$this->load->view('admin/datacalon', $data);
		$this->load->view('admin/footer', $data);
	}
	public function hasilvote() {
		if(! $this->session->userdata('username'))
		{
			redirect('admin/login');
		}
		$data['vote']		= $this->Admin_Model->hasilvote();
		$data['jmlpemilih']	= $this->Admin_Model->countpemilih();
		$data['jmlvote']	= $this->Admin_Model->countvote();
		$data['idsekolah']	= $this->Admin_Model->idsekolah();
		$this->load->view('admin/head');
		$this->load->view('admin/admin-navbar');
		$this->load->view('admin/hasilvote', $data);
	
		$this->load->view('admin/footer', $data);
	}
	public function daftarhadir() {
		if(! $this->session->userdata('username'))
		{
			redirect('admin/login');
		}
		$data['vote']			= $this->Admin_Model->hasilvote();
		$data['jmlpemilih']		= $this->Admin_Model->countpemilih();
		$data['jmlvote']		= $this->Admin_Model->countvote();
		$data['idsekolah']		= $this->Admin_Model->idsekolah();
		$data['daftarhadir']	= $this->Admin_Model->daftarhadir();
		$this->load->view('admin/head');
		$this->load->view('admin/admin-navbar');
		$this->load->view('admin/daftarhadir', $data);
		$this->load->view('admin/footer', $data);
	}
	public function tgl_indo($tanggal){
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
	 
		return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}
	public function cetakdaftarhadir(){
		$datasekolah	= $this->Admin_Model->idsekolah();
		$data			=	$this->Admin_Model->daftarhadir();
		foreach($datasekolah as $loaddata) {}
		ob_start();
		$pdf = new FPDF('p', 'mm', 'a4');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(190,7, $loaddata['nm_sekolah'],0,1,'C');
		$pdf->Cell(190,7, 'Daftar Hadir Pemilihan Ketua Osis',0,1,'C');
		$pdf->Cell(10,7,'',0,1);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(10,10, 'No',1,0, 'C');
		$pdf->Cell(35,10, 'Nisn',1,0, 'C');
		$pdf->Cell(70,10, 'Nama',1,0, 'C');
		$pdf->Cell(35,10, 'Kelas',1,0, 'C');
		$pdf->Cell(35,10, 'Keterangan',1,1, 'C');
		$no = 1;
		$pdf->SetFont('Arial','',12);
		foreach($data as $load) {
			$pdf->cell(10,10, $no++ , 1,0, 'C' );
			$pdf->cell(35,10, $load['username'] , 1,0, 'C' );
			$pdf->cell(70,10, $load['nm_siswa'] , 1,0, 'L' );
			$pdf->cell(35,10, $load['nm_kelas'] , 1,0, 'C' );
			$pdf->cell(35,10, $load['hadir'] , 1,1, 'L' );
		}
		$pdf->Cell(10,7,'',0,1);
		$pdf->Cell(115,10, '',0,0, 'L');
		$pdf->Cell(70,10, $loaddata['desa'].', '. $this->tgl_indo(date('Y-m-d')),0,1, 'L');
		$pdf->Cell(115,10, '',0,0, 'L');
		$pdf->Cell(70,10, 'Kepala Sekolah',0,1, 'L');
		$pdf->Cell(10,20,'',0,1);
		$pdf->Cell(115,6, '',0,0, 'L');
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(70,6, $loaddata['kpl_sekolah'],0,1, 'L');
		$pdf->Cell(115,6, '',0,0, 'L');
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(70,6, 'NIP: '.$loaddata['nip'],0,1, 'L');
		$pdf->Output(); 
		ob_end_flush(); 
	}
	public function laporan(){
		$datasekolah	= $this->Admin_Model->idsekolah();
		$data			= $this->Admin_Model->daftarhadir();
		$jmldptL		= $this->Admin_Model->jmldptL();
		$jmldptP		= $this->Admin_Model->jmldptP();
		$jmlvoteL		= $this->Admin_Model->jmlvoteL();
		$jmlvoteP		= $this->Admin_Model->jmlvoteP();
		$datavote		= $this->Admin_Model->hasilvote();
		$datapilketos	= $this->Admin_Model->datapilketos();
		foreach($datasekolah as $loaddata) {}
		foreach($jmldptL as $dptL) {}
		foreach($jmldptP as $dptP) {}
		foreach($jmlvoteL as $voteL) {}
		foreach($jmlvoteP as $voteP) {}
		foreach($datapilketos as $data){}
		ob_start();
		$pdf = new FPDF('l', 'mm', 'legal');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		//HEADER LAPORAN
		$pdf->Cell(290,7, 'LAPORAN PELAKSANAAN PEMILIHAN KETUA OSIS',0,1,'C');
		$pdf->Cell(290,7, 'TAHUN PELAJARAN '.$data['tapel'],0,1,'C');
		$pdf->Cell(10,7,'',0,1);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(60,7, 'Kabupaten', 0,0);
		$pdf->Cell(5,7, ':', 0,0);
		$pdf->Cell(60,7, $loaddata['kab'], 0,1);
		$pdf->Cell(60,7, 'Tanggal Pelaksanaan', 0,0);
		$pdf->Cell(5,7, ':', 0,0);
		$pdf->Cell(60,7, $data['tgl'], 0,1);
		$pdf->SetFont('Arial','B',12);
		//TABLE HAEDER
		$pdf->Cell(10,21, 'No',1,0, 'C');
		$pdf->Cell(90,21, 'Nama Sekolah',1,0, 'C');
		$pdf->Cell(60,7, 'Daftar Pemilih Tetap',1,0, 'C');
		$pdf->Cell(60,7, 'Jumlah Yang Menggunakan',1,0, 'C');
		$pdf->Cell(80,7, 'Jumlah Yang Tidak Menggunakan',1,0, 'C');
		$pdf->Cell(1,7, '', 0,1);
		$pdf->Cell(10,7, '', 0,0);
		$pdf->Cell(90,7, '', 0,0);
		$pdf->Cell(60,7, '(DPT)',1,0, 'C');
		$pdf->Cell(60,7, 'Hak Suara',1,0, 'C');
		$pdf->Cell(80,7, 'Hak Suara',1,0, 'C');
		$pdf->Cell(1,7, '', 0,1);
		$pdf->Cell(10,7, '', 0,0);
		$pdf->Cell(90,7, '', 0,0);
		$pdf->Cell(20,7, 'L', 1,0, 'C');
		$pdf->Cell(20,7, 'P', 1,0, 'C');
		$pdf->Cell(20,7, 'Jumlah', 1,0, 'C');
		$pdf->Cell(20,7, 'L', 1,0, 'C');
		$pdf->Cell(20,7, 'P', 1,0, 'C');
		$pdf->Cell(20,7, 'Jumlah', 1,0, 'C');
		$pdf->Cell(20,7, 'L', 1,0, 'C');
		$pdf->Cell(20,7, 'P', 1,0, 'C');
		$pdf->Cell(40,7, 'Jumlah', 1,1, 'C');
		//ISI TABLE
		$dpttidaksahL = $dptL['L'] - $voteL['L'];
		$dpttidaksahP = $dptP['P'] - $voteP['P'];
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(10,10, '1',1,0, 'C');
		$pdf->Cell(90,10, $loaddata['nm_sekolah'],1,0, 'C');
		$pdf->Cell(20,10, $dptL['L'], 1,0, 'C');
		$pdf->Cell(20,10, $dptP['P'], 1,0, 'C');
		$pdf->Cell(20,10, $dptL['L'] + $dptP['P'], 1,0, 'C');
		$pdf->Cell(20,10, $voteL['L'], 1,0, 'C');
		$pdf->Cell(20,10, $voteP['P'], 1,0, 'C');
		$pdf->Cell(20,10, $voteL['L'] + $voteP['P'], 1,0, 'C');
		$pdf->Cell(20,10, $dpttidaksahL , 1,0, 'C');
		$pdf->Cell(20,10, $dpttidaksahP , 1,0, 'C');
		$pdf->Cell(40,10, $dpttidaksahL + $dpttidaksahP, 1,1, 'C');
		$pdf->Cell(10,7,'',0,1);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(60,7, 'Hasil Pemilihan', 0,1);
		$pdf->Cell(30,12, 'No Urut',1,0, 'C');
		$pdf->Cell(60,12, 'Nama Kandidat',1,0, 'C');
		$pdf->Cell(80,12, 'Jumlah Perolehan Suara',1,1, 'C');
		$pdf->SetFont('Arial','',12);
		foreach($datavote as $hasil) {
			$pdf->Cell(30,7, $hasil['no'],1,0, 'C');
			$pdf->Cell(60,7, $hasil['nama'],1,0, 'L');
			$pdf->Cell(80,7, $hasil['jumlah'],1,1, 'C');
		}
		//TANDA TANGAN
		$pdf->Cell(10,7,'',0,1);
		$pdf->Cell(220,10, '',0,0, 'L');
		$pdf->Cell(70,10, $loaddata['desa'].', '. $this->tgl_indo(date('Y-m-d')),0,1, 'L');
		$pdf->Cell(220,10, '',0,0, 'L');
		$pdf->Cell(70,10, 'Kepala Sekolah',0,1, 'L');
		$pdf->Cell(10,20,'',0,1);
		$pdf->Cell(220,6, '',0,0, 'L');
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(70,6, $loaddata['kpl_sekolah'],0,1, 'L');
		$pdf->Cell(220,6, '',0,0, 'L');
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(70,6, 'NIP: '.$loaddata['nip'],0,1, 'L');
		$pdf->Output();
		ob_end_flush(); 
	}

	public function election()
	{
		$this->load->model('Election_Model');
		$data = array(
			'election' => $this->Election_Model->election(),
			'school' => $this->Election_Model->school(),
			'candidates' => $this->Election_Model->candidates(),
			'results' => $this->Election_Model->results(),
			'votes' => $this->Election_Model->vote_count(),
			'voters' => $this->Election_Model->voter_count()
		);
		$this->load->view('admin/election', $data);
	}

	public function save_election()
	{
		$this->load->model('Election_Model');
		$status = $this->input->post('status', TRUE);
		$start_input = trim((string) $this->input->post('mulai', TRUE));
		$end_input = trim((string) $this->input->post('selesai', TRUE));
		$start = $this->_parse_datetime($start_input);
		$end = $this->_parse_datetime($end_input);
		if (!in_array($status, array('draft', 'open', 'closed'), TRUE)
			|| ($start_input !== '' && $start === FALSE)
			|| ($end_input !== '' && $end === FALSE)
			|| ($start && $end && strtotime($start) >= strtotime($end))) {
			$this->session->set_flashdata('error', 'Status atau rentang waktu pemilihan tidak valid.');
			redirect('admin/election');
		}
		$election_date = trim((string) $this->input->post('tgl', TRUE));
		$season = trim((string) $this->input->post('tapel', TRUE));
		$description = trim((string) $this->input->post('deskripsi', TRUE));
		if (($election_date !== '' && !$this->_valid_date($election_date))
			|| strlen($season) > 10 || strlen($description) > 5000) {
			$this->session->set_flashdata('error', 'Tanggal, tahun pelajaran, atau informasi pemilihan tidak valid.');
			redirect('admin/election');
		}
		$this->load->model('Election_Model');
		if ($status === 'open' && (count($this->Election_Model->candidates()) < 2
			|| $this->Election_Model->voter_count() < 1)) {
			$this->session->set_flashdata('error', 'Tambahkan minimal dua kandidat dan satu pemilih sebelum membuka pemungutan suara.');
			redirect('admin/election');
		}

		$school_name = $this->input->post('nm_sekolah', TRUE);
		if (!$school_name || strlen($school_name) > 32) {
			$this->session->set_flashdata('error', 'Nama sekolah wajib diisi (maksimal 32 karakter).');
			redirect('admin/election');
		}
		$school_limits = array('jln' => 32, 'desa' => 32, 'kec' => 32, 'kab' => 32, 'kpl_sekolah' => 32, 'nip' => 16);
		foreach ($school_limits as $field => $limit) {
			if (strlen((string) $this->input->post($field, TRUE)) > $limit) {
				$this->session->set_flashdata('error', 'Data identitas sekolah melebihi batas panjang yang diizinkan.');
				redirect('admin/election');
			}
		}
		$this->db->trans_begin();
		$school = $this->Election_Model->school();
		$school_data = array('nm_sekolah' => $school_name);
		foreach (array('jln', 'desa', 'kec', 'kab', 'kpl_sekolah', 'nip') as $field) {
			$school_data[$field] = $this->input->post($field, TRUE);
		}
		if ($school) {
			$this->db->where('npsn', $school['npsn'])->update('tb_identitassekolah', $school_data);
		}
		$save_ok = $this->Election_Model->save_election(array(
			'tapel' => $season,
			'tgl' => $election_date ?: '2000-01-01',
			'deskripsi' => $description,
			'status' => $status,
			'mulai' => $start,
			'selesai' => $end,
			'hasil_ditampilkan' => $this->input->post('hasil_ditampilkan') ? 1 : 0
		));
		if ($save_ok && $this->db->trans_status() !== FALSE) {
			$this->db->trans_commit();
			$this->session->set_flashdata('success', 'Informasi pemilihan berhasil disimpan.');
		} else {
			$this->db->trans_rollback();
			$this->session->set_flashdata('error', 'Data tidak tersimpan. Periksa kembali konfigurasi database.');
		}
		redirect('admin/election');
	}

	public function save_candidate()
	{
		$this->load->model('Election_Model');
		$nisn = trim((string) $this->input->post('nisn', TRUE));
		$name = trim((string) $this->input->post('nama', TRUE));
		$number = trim((string) $this->input->post('no', TRUE));
		$editing = $this->input->post('editing') === '1';
		$existing = $editing ? $this->Election_Model->candidate($nisn) : NULL;
		if (!$nisn || strlen($nisn) > 32 || !preg_match('/^[A-Za-z0-9._-]+$/', $nisn)
			|| !$name || strlen($name) > 32 || !ctype_digit($number)
			|| (int) $number < 1 || (int) $number > 99
			|| strlen((string) $this->input->post('visi', TRUE)) > 5000
			|| strlen((string) $this->input->post('misi', TRUE)) > 5000
			|| ($editing && !$existing)) {
			$this->session->set_flashdata('error', 'Data kandidat tidak valid. Periksa NISN, nama, dan nomor urut.');
			redirect('admin/election');
		}
		if ($this->Election_Model->vote_count() > 0) {
			$this->session->set_flashdata('error', 'Data kandidat dikunci setelah suara pertama tercatat.');
			redirect('admin/election');
		}

		$data = array(
			'nisn' => $nisn,
			'no' => (int) $number,
			'nama' => $name,
			'visi' => trim((string) $this->input->post('visi', TRUE)),
			'misi' => trim((string) $this->input->post('misi', TRUE))
		);
		$photo = $existing ? $existing['photo'] : '';
		$uploaded_photo = NULL;
		if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
			$this->load->library('upload');
			$config = array(
				'upload_path' => FCPATH.'uploads/candidates/',
				'allowed_types' => 'jpg|jpeg|png',
				'max_size' => 2048,
				'encrypt_name' => TRUE,
				'detect_mime' => TRUE,
				'remove_spaces' => TRUE
			);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('photo')) {
				$this->session->set_flashdata('error', strip_tags($this->upload->display_errors('', '')));
				redirect('admin/election');
			}
			$upload = $this->upload->data();
			$photo = 'uploads/candidates/'.$upload['file_name'];
			$uploaded_photo = FCPATH.$photo;
		}
		if (!$photo) {
			$this->session->set_flashdata('error', 'Foto kandidat wajib diunggah.');
			redirect('admin/election');
		}
		$data['photo'] = $photo;
		$saved = $editing
			? $this->Election_Model->update_candidate($nisn, $data)
			: $this->Election_Model->add_candidate($data);
		if (!$saved && $uploaded_photo && is_file($uploaded_photo)) {
			unlink($uploaded_photo);
		}
		$this->session->set_flashdata(
			$saved ? 'success' : 'error',
			$saved ? 'Data kandidat berhasil disimpan.' : 'Kandidat gagal disimpan. Pastikan NISN belum digunakan.'
		);
		redirect('admin/election');
	}

	public function delete_candidate()
	{
		$this->load->model('Election_Model');
		$nisn = trim((string) $this->input->post('nisn', TRUE));
		$deleted = $this->Election_Model->vote_count() === 0
			&& $this->Election_Model->delete_candidate($nisn);
		$this->session->set_flashdata(
			$deleted ? 'success' : 'error',
			$deleted ? 'Kandidat berhasil dihapus.' : 'Kandidat tidak dapat dihapus setelah suara tercatat.'
		);
		redirect('admin/election');
	}

	public function create_admin($username = '')
	{
		if (!$this->input->is_cli_request()) {
			show_error('This command can only be run from the command line.', 403);
		}
		$username = trim($username);
		if (!preg_match('/^[A-Za-z0-9._-]{3,32}$/', $username)) {
			echo "Usage: php index.php admin create_admin <username>\n";
			exit(1);
		}
		if ($this->Admin_Model->admin_count() > 0) {
			echo "An administrator already exists. Use the admin password-change page.\n";
			exit(1);
		}
		$password = bin2hex(random_bytes(16));
		if (!$this->Admin_Model->create_initial_admin($username, password_hash($password, PASSWORD_DEFAULT))) {
			echo "Administrator creation failed or another administrator was created concurrently.\n";
			exit(1);
		}
		echo "Administrator created. Save this one-time password securely:\n".$password."\n";
	}

	private function _parse_datetime($value)
	{
		if ($value === '') {
			return NULL;
		}
		$date = DateTime::createFromFormat('Y-m-d\TH:i', $value);
		$errors = DateTime::getLastErrors();
		if (!$date || ($errors && ($errors['warning_count'] || $errors['error_count']))
			|| $date->format('Y-m-d\TH:i') !== $value) {
			return FALSE;
		}
		return $date->format('Y-m-d H:i:s');
	}

	private function _valid_date($value)
	{
		$date = DateTime::createFromFormat('Y-m-d', $value);
		$errors = DateTime::getLastErrors();
		return $date && (!$errors || (!$errors['warning_count'] && !$errors['error_count']))
			&& $date->format('Y-m-d') === $value;
	}

	private function _candidate_updates_locked()
	{
		$this->load->model('Election_Model');
		return $this->Election_Model->vote_count() > 0;
	}
}
 ?> 