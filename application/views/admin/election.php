<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$election = is_array($election) ? $election : array();
$school = is_array($school) ? $school : array();
$locked = (int) $votes > 0;
$format_datetime = function ($value) {
	if (!$value || strpos($value, '2000-01-01') === 0) {
		return '';
	}
	return date('Y-m-d\TH:i', strtotime($value));
};
?>
<!doctype html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Kelola pemilihan | E-Pilketos</title>
	<style>
		:root{--ink:#182b3a;--muted:#667787;--blue:#1769aa;--paper:#f2f6f9;--line:#dfe7ed;--red:#a33131;--green:#167553}
		*{box-sizing:border-box}body{margin:0;background:var(--paper);color:var(--ink);font:15px/1.5 system-ui,-apple-system,"Segoe UI",sans-serif}
		header{background:#123f64;color:white}.wrap{width:min(1160px,calc(100% - 32px));margin:auto}.nav{min-height:70px;display:flex;align-items:center;justify-content:space-between;gap:15px}.nav strong{font-size:1.15rem}.nav a{color:white}
		main{padding:28px 0 50px}.intro{margin-bottom:20px}.intro h1{margin:0 0 4px;font-size:1.8rem}.muted{color:var(--muted)}.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin:18px 0}.stat,.panel{background:white;border:1px solid var(--line);border-radius:12px}.stat{padding:16px}.stat b{display:block;font-size:1.6rem}.stat span{color:var(--muted)}
		.layout{display:grid;grid-template-columns:minmax(0,1fr) minmax(300px,.85fr);align-items:start;gap:18px}.panel{padding:20px;margin-bottom:18px}.panel h2{font-size:1.2rem;margin:0 0 16px}.panel h3{font-size:1.05rem}.field{margin:0 0 13px}.field label{display:block;font-weight:700;margin-bottom:5px}.field input,.field textarea,.field select{width:100%;border:1px solid #cbd5de;border-radius:7px;padding:10px 11px;font:inherit;color:inherit;background:#fff}.field textarea{min-height:82px;resize:vertical}.fields{display:grid;grid-template-columns:1fr 1fr;gap:0 12px}
		.button{display:inline-block;border:0;border-radius:7px;background:var(--blue);color:white;padding:10px 15px;font:inherit;font-weight:700;cursor:pointer}.button.danger{background:var(--red)}.button.secondary{background:#e7eff5;color:#174c72}.actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap}.alert{border-radius:8px;padding:12px 15px;margin:0 0 16px}.alert.success{background:#e6f5ee;color:#145f43}.alert.error{background:#fff0ed;color:#8e2e24}
		.candidate{border-top:1px solid var(--line);padding-top:17px;margin-top:18px}.candidate:first-of-type{border-top:0;padding-top:0;margin-top:0}.candidate-grid{display:grid;grid-template-columns:100px minmax(0,1fr);gap:15px}.photo{width:100px;height:120px;object-fit:cover;background:#e9eef2;border-radius:7px}.candidate h3{margin:0 0 9px}.help{font-size:.86rem;color:var(--muted)}.result{padding:12px 0;border-top:1px solid var(--line)}.result:first-of-type{border-top:0}.result-top{display:flex;justify-content:space-between;gap:12px}.bar{height:8px;border-radius:8px;background:#eaf0f5;margin-top:8px}.bar span{display:block;height:100%;background:var(--blue);border-radius:8px}
		@media(max-width:800px){.layout{grid-template-columns:1fr}}@media(max-width:520px){.fields{grid-template-columns:1fr}.nav{min-height:62px}.candidate-grid{grid-template-columns:75px minmax(0,1fr)}.photo{width:75px;height:92px}.panel{padding:16px}}
	</style>
</head>
<body>
<header><div class="wrap nav">
	<strong>Panel panitia · <?php echo html_escape(!empty($school['nm_sekolah']) ? $school['nm_sekolah'] : 'E-Pilketos'); ?></strong>
	<div class="actions"><a href="<?php echo site_url('admin/datadpt'); ?>">DPT</a><a href="<?php echo site_url('admin/datakelas'); ?>">Kelas</a><a href="<?php echo site_url('admin/idsekolah'); ?>">Identitas</a><a href="<?php echo site_url('admin/logout'); ?>">Keluar</a></div>
</div></header>
<main class="wrap">
	<div class="intro"><h1>Pengaturan pemilihan</h1><div class="muted">Konten dan status tersimpan pada database server.</div></div>
	<?php if ($this->session->flashdata('success')): ?><div class="alert success"><?php echo html_escape($this->session->flashdata('success')); ?></div><?php endif; ?>
	<?php if ($this->session->flashdata('error')): ?><div class="alert error"><?php echo html_escape($this->session->flashdata('error')); ?></div><?php endif; ?>
	<div class="stats">
		<div class="stat"><b><?php echo count($candidates); ?></b><span>Kandidat</span></div>
		<div class="stat"><b><?php echo (int) $votes; ?></b><span>Suara masuk</span></div>
		<div class="stat"><b><?php echo (int) $voters; ?></b><span>Pemilih terdaftar</span></div>
		<div class="stat"><b><?php echo !empty($election['status']) ? html_escape(ucfirst($election['status'])) : 'Draft'; ?></b><span>Status pemilihan</span></div>
	</div>
	<div class="layout">
		<section>
			<div class="panel">
				<h2>Informasi dan periode pemilihan</h2>
				<?php echo form_open('admin/save_election'); ?>
					<div class="fields">
						<div class="field"><label for="school">Nama sekolah</label><input id="school" name="nm_sekolah" maxlength="32" required value="<?php echo html_escape(isset($school['nm_sekolah']) ? $school['nm_sekolah'] : ''); ?>"></div>
						<div class="field"><label for="season">Tahun pelajaran</label><input id="season" name="tapel" maxlength="10" value="<?php echo html_escape(isset($election['tapel']) ? $election['tapel'] : ''); ?>"></div>
						<div class="field"><label for="date">Tanggal pemilihan</label><input id="date" type="date" name="tgl" value="<?php echo !empty($election['tgl']) && $election['tgl'] !== '0000-00-00' && $election['tgl'] !== '2000-01-01' ? html_escape($election['tgl']) : ''; ?>"></div>
						<div class="field"><label for="status">Status</label><select id="status" name="status"><option value="draft" <?php echo empty($election['status']) || $election['status'] === 'draft' ? 'selected' : ''; ?>>Draft / belum dibuka</option><option value="open" <?php echo !empty($election['status']) && $election['status'] === 'open' ? 'selected' : ''; ?>>Buka pemungutan suara</option><option value="closed" <?php echo !empty($election['status']) && $election['status'] === 'closed' ? 'selected' : ''; ?>>Tutup pemungutan suara</option></select></div>
						<div class="field"><label for="start">Mulai (opsional)</label><input id="start" type="datetime-local" name="mulai" value="<?php echo html_escape($format_datetime(isset($election['mulai']) ? $election['mulai'] : NULL)); ?>"></div>
						<div class="field"><label for="end">Selesai (opsional)</label><input id="end" type="datetime-local" name="selesai" value="<?php echo html_escape($format_datetime(isset($election['selesai']) ? $election['selesai'] : NULL)); ?>"></div>
					</div>
					<div class="field"><label for="description">Informasi pemilihan</label><textarea id="description" name="deskripsi" maxlength="5000"><?php echo html_escape(isset($election['deskripsi']) ? $election['deskripsi'] : ''); ?></textarea></div>
					<div class="fields">
						<div class="field"><label for="village">Desa / kelurahan</label><input id="village" name="desa" maxlength="32" value="<?php echo html_escape(isset($school['desa']) ? $school['desa'] : ''); ?>"></div>
						<div class="field"><label for="district">Kecamatan</label><input id="district" name="kec" maxlength="32" value="<?php echo html_escape(isset($school['kec']) ? $school['kec'] : ''); ?>"></div>
						<div class="field"><label for="regency">Kabupaten</label><input id="regency" name="kab" maxlength="32" value="<?php echo html_escape(isset($school['kab']) ? $school['kab'] : ''); ?>"></div>
						<div class="field"><label for="principal">Kepala sekolah</label><input id="principal" name="kpl_sekolah" maxlength="32" value="<?php echo html_escape(isset($school['kpl_sekolah']) ? $school['kpl_sekolah'] : ''); ?>"></div>
						<div class="field"><label for="address">Alamat</label><input id="address" name="jln" maxlength="32" value="<?php echo html_escape(isset($school['jln']) ? $school['jln'] : ''); ?>"></div>
						<div class="field"><label for="nip">NIP</label><input id="nip" name="nip" maxlength="16" value="<?php echo html_escape(isset($school['nip']) ? $school['nip'] : ''); ?>"></div>
					</div>
					<div class="field"><label><input type="checkbox" name="hasil_ditampilkan" value="1" <?php echo !empty($election['hasil_ditampilkan']) ? 'checked' : ''; ?>> Tampilkan hasil publik setelah pemilihan ditutup</label></div>
					<button class="button" type="submit">Simpan informasi</button>
				<?php echo form_close(); ?>
			</div>

			<div class="panel">
				<h2>Tambah kandidat</h2>
				<?php if ($locked): ?><p class="help">Data kandidat dikunci karena suara sudah tercatat untuk menjaga integritas hasil.</p><?php else: ?>
					<?php echo form_open_multipart('admin/save_candidate'); ?>
						<input type="hidden" name="editing" value="0">
						<div class="fields">
							<div class="field"><label>NISN / ID kandidat</label><input name="nisn" maxlength="32" pattern="[A-Za-z0-9._-]+" required></div>
							<div class="field"><label>Nomor urut</label><input name="no" type="number" min="1" max="99" required></div>
						</div>
						<div class="field"><label>Nama</label><input name="nama" maxlength="32" required></div>
						<div class="field"><label>Visi</label><textarea name="visi" maxlength="5000"></textarea></div>
						<div class="field"><label>Misi</label><textarea name="misi" maxlength="5000"></textarea></div>
						<div class="field"><label>Foto kandidat (JPG/PNG, maksimal 2 MB)</label><input name="photo" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png" required></div>
						<button class="button" type="submit">Tambah kandidat</button>
					<?php echo form_close(); ?>
				<?php endif; ?>
			</div>
		</section>
		<aside>
			<div class="panel">
				<h2>Kandidat</h2>
				<?php if (!$candidates): ?><p class="muted">Belum ada kandidat.</p><?php endif; ?>
				<?php foreach ($candidates as $candidate): ?>
					<?php
					$image = strpos($candidate['photo'], '/') !== FALSE ? $candidate['photo'] : 'asset/img/'.$candidate['photo'];
					?>
					<div class="candidate">
						<div class="candidate-grid">
							<img class="photo" src="<?php echo html_escape(base_url($image)); ?>" alt="">
							<div><h3><?php echo html_escape($candidate['no'].'. '.$candidate['nama']); ?></h3><div class="help">ID: <?php echo html_escape($candidate['nisn']); ?></div></div>
						</div>
						<?php if (!$locked): ?>
							<div class="actions">
							<?php echo form_open_multipart('admin/save_candidate'); ?>
								<input type="hidden" name="editing" value="1">
								<input type="hidden" name="nisn" value="<?php echo html_escape($candidate['nisn']); ?>">
								<div class="fields">
									<div class="field"><label>Nomor urut</label><input name="no" type="number" min="1" max="99" required value="<?php echo html_escape($candidate['no']); ?>"></div>
									<div class="field"><label>Nama</label><input name="nama" maxlength="32" required value="<?php echo html_escape($candidate['nama']); ?>"></div>
								</div>
								<div class="field"><label>Visi</label><textarea name="visi" maxlength="5000"><?php echo html_escape(isset($candidate['visi']) ? $candidate['visi'] : ''); ?></textarea></div>
								<div class="field"><label>Misi</label><textarea name="misi" maxlength="5000"><?php echo html_escape(isset($candidate['misi']) ? $candidate['misi'] : ''); ?></textarea></div>
								<div class="field"><label>Ganti foto (opsional)</label><input name="photo" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png"></div>
								<button class="button secondary" type="submit">Simpan perubahan</button>
							<?php echo form_close(); ?>
							<?php echo form_open('admin/delete_candidate', array('onsubmit' => "return confirm('Hapus kandidat ini?');")); ?>
								<input type="hidden" name="nisn" value="<?php echo html_escape($candidate['nisn']); ?>">
								<button class="button danger" type="submit">Hapus</button>
							<?php echo form_close(); ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="panel">
				<h2>Hasil suara (khusus panitia)</h2>
				<?php $total = 0; foreach ($results as $result) { $total += (int) $result['jumlah']; } ?>
				<?php if (!$results): ?><p class="muted">Belum ada data kandidat.</p><?php endif; ?>
				<?php foreach ($results as $result): ?>
					<?php $share = $total ? round(((int) $result['jumlah'] / $total) * 100, 1) : 0; ?>
					<div class="result"><div class="result-top"><strong><?php echo html_escape($result['no'].'. '.$result['nama']); ?></strong><span><?php echo (int) $result['jumlah']; ?> suara · <?php echo $share; ?>%</span></div><div class="bar"><span style="width:<?php echo $share; ?>%"></span></div></div>
				<?php endforeach; ?>
				<p class="help">Hasil publik hanya muncul setelah status pemilihan ditutup dan opsi publik diaktifkan.</p>
			</div>
			<div class="panel"><h2>Akun administrator</h2><a class="button secondary" href="<?php echo site_url('admin/gantipassword'); ?>">Ganti password</a></div>
		</aside>
	</div>
</main>
</body>
</html>
