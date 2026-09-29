<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$school_name = !empty($school['nm_sekolah']) ? $school['nm_sekolah'] : 'Pemilihan Ketua OSIS';
$season = !empty($election['tapel']) ? $election['tapel'] : 'Periode pemilihan';
$status_labels = array('draft' => 'Belum dibuka', 'open' => 'Pemungutan suara', 'closed' => 'Selesai');
$status = isset($election['status'], $status_labels[$election['status']])
	? $status_labels[$election['status']]
	: 'Belum dikonfigurasi';
$can_show_results = !empty($election['hasil_ditampilkan']) && isset($election['status'])
	&& $election['status'] === 'closed';
$result_total = 0;
foreach ($results as $result) {
	$result_total += (int) $result['jumlah'];
}
?>
<!doctype html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo html_escape($school_name); ?> | E-Pilketos</title>
	<style>
		:root{--ink:#172a3a;--muted:#617080;--blue:#1769aa;--blue2:#0e4b80;--paper:#f4f7fa;--line:#e1e8ee;--green:#167553}
		*{box-sizing:border-box}body{margin:0;background:var(--paper);color:var(--ink);font:16px/1.55 system-ui,-apple-system,"Segoe UI",sans-serif}
		a{color:var(--blue);text-decoration:none}.wrap{width:min(1120px,calc(100% - 36px));margin:auto}
		header{background:#fff;border-bottom:1px solid var(--line)}.nav{min-height:72px;display:flex;justify-content:space-between;align-items:center;gap:20px}
		.brand{font-weight:800;font-size:1.08rem;color:var(--ink)}.brand small{display:block;color:var(--muted);font-size:.78rem;font-weight:500}
		.button{display:inline-block;border:0;border-radius:8px;background:var(--blue);color:#fff;padding:11px 17px;font:inherit;font-weight:700;cursor:pointer}
		.button:hover{background:var(--blue2);color:#fff}.button.secondary{background:#eaf2f8;color:var(--blue2)}
		.hero{margin:30px auto 22px;padding:42px;border-radius:18px;background:linear-gradient(125deg,#113f66,#1978b8);color:white}
		.hero .eyebrow{font-size:.85rem;font-weight:700;letter-spacing:.09em;text-transform:uppercase;opacity:.8}.hero h1{font-size:clamp(2rem,5vw,3.2rem);line-height:1.1;margin:12px 0}.hero p{max-width:700px;color:#e1eff9;margin:0}
		.status{display:inline-block;margin-top:22px;padding:6px 11px;border-radius:30px;background:#ffffff24;font-weight:700;font-size:.88rem}
		.section-head{display:flex;align-items:end;justify-content:space-between;gap:12px;margin:34px 0 16px}.section-head h2{font-size:1.45rem;margin:0}.muted{color:var(--muted)}
		.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,290px),1fr));gap:18px}.card{background:white;border:1px solid var(--line);border-radius:14px;overflow:hidden}
		.portrait{width:100%;height:265px;object-fit:cover;background:#eaf0f5}.card-body{padding:20px}.number{display:inline-block;padding:4px 10px;border-radius:20px;background:#eaf2f8;color:var(--blue2);font-weight:800;font-size:.8rem}
		.card h3{margin:10px 0 6px;font-size:1.35rem}.card h4{margin:16px 0 3px;font-size:.9rem}.card p{margin:0;color:var(--muted);white-space:pre-line}.vote-form{margin-top:18px}
		.notice{padding:14px 17px;border:1px solid #d8e7f1;background:#fff;border-radius:10px;color:var(--muted);margin:18px 0}
		.results{display:grid;gap:13px}.result-row{padding:15px 18px;background:white;border:1px solid var(--line);border-radius:10px}.result-top{display:flex;justify-content:space-between;gap:12px}.bar{height:9px;margin-top:10px;background:#eaf0f5;border-radius:8px;overflow:hidden}.bar span{display:block;height:100%;background:var(--blue);border-radius:8px}
		footer{padding:32px 0 45px;text-align:center;color:var(--muted);font-size:.9rem}
		@media(max-width:600px){.hero{padding:28px 22px}.nav{min-height:64px}.brand{font-size:.94rem}.button{padding:9px 12px;font-size:.9rem}.section-head{align-items:start;flex-direction:column}}
	</style>
</head>
<body>
<header><div class="wrap nav">
	<a class="brand" href="<?php echo base_url(); ?>"><?php echo html_escape($school_name); ?><small>E-Pilketos · <?php echo html_escape($season); ?></small></a>
	<?php if ($is_voter): ?>
		<div><a class="button secondary" href="<?php echo site_url('user/change_password'); ?>">Ganti password</a> <a class="button secondary" href="<?php echo site_url('user/logout'); ?>">Keluar</a></div>
	<?php else: ?>
		<a class="button" href="<?php echo site_url('user/login'); ?>">Masuk untuk memilih</a>
	<?php endif; ?>
</div></header>
<main class="wrap">
	<?php if ($this->session->flashdata('success')): ?><div class="notice"><?php echo html_escape($this->session->flashdata('success')); ?></div><?php endif; ?>
	<?php if ($this->session->flashdata('error')): ?><div class="notice"><?php echo html_escape($this->session->flashdata('error')); ?></div><?php endif; ?>
	<section class="hero">
		<div class="eyebrow">Pemilihan Ketua OSIS</div>
		<h1><?php echo html_escape($school_name); ?></h1>
		<p><?php echo !empty($election['deskripsi']) ? nl2br(html_escape($election['deskripsi'])) : 'Kenali para kandidat dan gunakan hak pilihmu dalam pemilihan Ketua OSIS.'; ?></p>
		<span class="status"><?php echo html_escape($status); ?></span>
		<?php if (!empty($election['mulai']) || !empty($election['selesai'])): ?>
			<p style="margin-top:12px">
				<?php if (!empty($election['mulai'])): ?>Mulai: <?php echo html_escape($election['mulai']); ?><?php endif; ?>
				<?php if (!empty($election['selesai'])): ?> · Ditutup: <?php echo html_escape($election['selesai']); ?><?php endif; ?>
			</p>
		<?php elseif (!empty($election['tgl']) && $election['tgl'] !== '2000-01-01' && $election['tgl'] !== '0000-00-00'): ?>
			<p style="margin-top:12px">Tanggal pemilihan: <?php echo html_escape($election['tgl']); ?></p>
		<?php endif; ?>
	</section>

	<div class="section-head"><div><h2>Kenali kandidat</h2><div class="muted">Baca visi dan misi sebelum menentukan pilihan.</div></div></div>
	<?php if (!$candidates): ?>
		<div class="notice">Informasi kandidat akan ditampilkan di sini setelah panitia menambahkannya.</div>
	<?php else: ?>
		<div class="grid">
			<?php foreach ($candidates as $candidate): ?>
				<?php
				$photo = isset($candidate['photo']) && strpos($candidate['photo'], '/') !== FALSE
					? $candidate['photo']
					: 'asset/img/'.(isset($candidate['photo']) ? $candidate['photo'] : '');
				?>
				<article class="card">
					<img class="portrait" src="<?php echo html_escape(base_url($photo)); ?>" alt="Foto <?php echo html_escape($candidate['nama']); ?>">
					<div class="card-body">
						<span class="number">NOMOR URUT <?php echo html_escape($candidate['no']); ?></span>
						<h3><?php echo html_escape($candidate['nama']); ?></h3>
						<h4>Visi</h4><p><?php echo !empty($candidate['visi']) ? nl2br(html_escape($candidate['visi'])) : 'Belum diisi.'; ?></p>
						<h4>Misi</h4><p><?php echo !empty($candidate['misi']) ? nl2br(html_escape($candidate['misi'])) : 'Belum diisi.'; ?></p>
						<?php if ($is_voter && $can_vote && !$has_voted && empty($require_password_change)): ?>
							<?php echo form_open('user/vote', array('class' => 'vote-form', 'onsubmit' => "return confirm('Gunakan hak pilih untuk kandidat ini? Pilihan tidak dapat diubah.');")); ?>
								<input type="hidden" name="nisn" value="<?php echo html_escape($candidate['nisn']); ?>">
								<button class="button" type="submit">Pilih kandidat ini</button>
							<?php echo form_close(); ?>
						<?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ($is_voter && $has_voted): ?>
		<div class="notice">Suaramu sudah tercatat. Terima kasih telah berpartisipasi.</div>
	<?php elseif ($is_voter && !empty($require_password_change)): ?>
		<div class="notice">Akun ini masih memakai password awal. Demi keamanan, <a href="<?php echo site_url('user/change_password'); ?>">ganti password sebelum memberikan suara</a>.</div>
	<?php elseif ($is_voter && !$can_vote): ?>
		<div class="notice">Pemungutan suara belum dibuka atau sudah berakhir. Kandidat dan informasi pemilihan tetap dapat dilihat.</div>
	<?php elseif (!$is_voter && $can_vote): ?>
		<div class="notice">Pemungutan suara sedang berlangsung. <a href="<?php echo site_url('user/login'); ?>">Masuk dengan akun pemilih</a> untuk memberikan suara.</div>
	<?php endif; ?>

	<?php if ($can_show_results): ?>
		<div class="section-head"><div><h2>Hasil pemilihan</h2><div class="muted"><?php echo $result_total; ?> suara tercatat.</div></div></div>
		<div class="results">
			<?php foreach ($results as $result): ?>
				<?php $percent = $result_total ? round(((int) $result['jumlah'] / $result_total) * 100, 1) : 0; ?>
				<div class="result-row"><div class="result-top"><strong><?php echo html_escape($result['no'].'. '.$result['nama']); ?></strong><span><?php echo (int) $result['jumlah']; ?> suara · <?php echo $percent; ?>%</span></div><div class="bar"><span style="width:<?php echo $percent; ?>%"></span></div></div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</main>
<footer class="wrap">Informasi pemilihan tersimpan dan dikelola oleh panitia sekolah.</footer>
</body>
</html>
