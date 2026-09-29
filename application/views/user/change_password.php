<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ganti password | E-Pilketos</title>
	<style>
		*{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:20px;background:#f2f6f9;color:#192e3e;font:16px/1.5 system-ui,-apple-system,"Segoe UI",sans-serif}main{width:min(460px,100%);padding:28px;background:white;border:1px solid #dfe7ed;border-radius:13px}h1{font-size:1.5rem;margin:0 0 7px}.muted{color:#617080}.field{margin:14px 0}label{display:block;font-weight:700;margin-bottom:5px}input{width:100%;padding:11px;border:1px solid #cbd5de;border-radius:7px;font:inherit}.button{border:0;border-radius:7px;background:#1769aa;color:#fff;padding:11px 15px;font:inherit;font-weight:700;cursor:pointer}.notice{padding:11px;background:#eef4f8;border-radius:7px;margin:15px 0}.error{padding:11px;background:#fff0ed;color:#8e2e24;border-radius:7px;margin:15px 0}a{color:#1769aa}
	</style>
</head>
<body>
<main>
	<h1>Ganti password pemilih</h1>
	<p class="muted"><?php echo $required ? 'Password awal wajib diganti sebelum memberikan suara.' : 'Gunakan password baru yang hanya kamu ketahui.'; ?></p>
	<?php if ($this->session->flashdata('error')): ?><div class="error"><?php echo html_escape($this->session->flashdata('error')); ?></div><?php endif; ?>
	<?php echo form_open('user/update_password'); ?>
		<div class="field"><label for="current">Password saat ini</label><input id="current" type="password" name="current_password" autocomplete="current-password" required></div>
		<div class="field"><label for="new">Password baru</label><input id="new" type="password" name="new_password" autocomplete="new-password" minlength="12" required></div>
		<div class="field"><label for="confirm">Ulangi password baru</label><input id="confirm" type="password" name="confirm_password" autocomplete="new-password" minlength="12" required></div>
		<button class="button" type="submit">Simpan password</button>
	<?php echo form_close(); ?>
	<div class="notice">Gunakan minimal 12 karakter. Password disimpan dengan hash yang aman.</div>
	<a href="<?php echo site_url('user/index'); ?>">Kembali</a>
</main>
</body>
</html>
