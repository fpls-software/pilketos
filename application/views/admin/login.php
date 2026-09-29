<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login panitia | E-Pilketos</title>
	<style>
		*{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:22px;background:linear-gradient(135deg,#143f63,#1b79b7);font:16px/1.5 system-ui,-apple-system,"Segoe UI",sans-serif;color:#192e3e}
		main{width:min(430px,100%);padding:30px;background:#fff;border-radius:15px;box-shadow:0 20px 55px #08223e55}h1{margin:0 0 4px;font-size:1.55rem}.muted{color:#617080;margin:0 0 22px}.field{margin-bottom:14px}label{display:block;font-weight:700;margin-bottom:5px}input{width:100%;padding:11px;border:1px solid #cbd5de;border-radius:7px;font:inherit}.button{width:100%;border:0;border-radius:7px;background:#1769aa;color:white;padding:12px;font:inherit;font-weight:700;cursor:pointer}.error{padding:11px 13px;margin-bottom:15px;border-radius:8px;background:#fff0ed;color:#8e2e24}.setup{margin-top:18px;padding:12px;border-radius:8px;background:#eef4f8;color:#40576a;font-size:.9rem}a{color:#1769aa}
	</style>
</head>
<body>
<main>
	<h1>Login panitia</h1>
	<p class="muted">Masuk untuk mengelola pemilihan dan kandidat.</p>
	<?php if ($this->session->flashdata('failed')): ?><div class="error"><?php echo html_escape($this->session->flashdata('failed')); ?></div><?php endif; ?>
	<?php echo form_open('admin/loginvalidation'); ?>
		<div class="field"><label for="username">Username</label><input id="username" name="username" autocomplete="username" maxlength="32" required autofocus></div>
		<div class="field"><label for="password">Password</label><input id="password" name="password" type="password" autocomplete="current-password" required></div>
		<button class="button" type="submit">Masuk</button>
	<?php echo form_close(); ?>
	<?php if (empty($admin_count)): ?>
		<div class="setup">Belum ada administrator. Buat akun awal hanya melalui terminal server dengan perintah <code>php index.php admin create_admin &lt;username&gt;</code>.</div>
	<?php endif; ?>
	<p class="muted" style="margin:18px 0 0"><a href="<?php echo base_url(); ?>">Kembali ke halaman pemilihan</a></p>
</main>
</body>
</html>
