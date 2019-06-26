<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Myframework - Build something</title>
	<style type="text/css">
		* {
			font-family: Arial, sans-serrif;
		}
	</style>
</head>
<body>
	<?php Flasher::get(); ?>
	<h2>Myframework</h2>
	<form action="<?= base_url('welcome/insert'); ?>" method="POST">
		<div class="form-inline">
			<input type="text" name="nama_kota" placeholder="Masukkan nama kota">
			<button type="submit">Simpan</button>
		</div>
	</form>
	<h4>Daftar Kota</h4>
	<ul>
		<?php foreach ($data['kota'] as $kota) : ?>
			<li><?= $kota['nama']; ?> <a href="<?= base_url('welcome/deleteKota/'.$kota['id']); ?>">Delete</a></li>
		<?php endforeach; ?>
	</ul>
	<br>
	<form action="<?= base_url('welcome/insertUser'); ?>" method="POST">
		<div class="form-inline">
			<input type="text" name="nama" placeholder="Masukkan nama"><br>
			<input type="text" name="email" placeholder="Masukkan email"><br>
			<button type="submit">Simpan</button>
		</div>
	</form>
	<h4>Daftar User</h4>
	<ul>
		<?php foreach ($data['user'] as $user) : ?>
			<li><?= $user['nama']; ?> <a href="<?= base_url('welcome/deleteUser/'.$user['id']); ?>">Delete</a></li>
			<br><br>
		<?php endforeach; ?>
	</ul>
	<form action="<?= base_url('welcome/isertFoto'); ?>" method="POST" enctype="multipart/form-data">
		<input type="file" name="foto">
		<button type="submit">Simpan</button>
	</form>
</body>
</html>