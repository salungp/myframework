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
	<form action="<?= base_url('welcome/updateUser'); ?>" method="POST">
		<div class="form-inline">
			<input type="hidden" name="id" placeholder="Masukkan nama" value="<?= $data['kota']['id']; ?>"><br>
			<input type="text" name="nama" placeholder="Masukkan nama" value="<?= $data['kota']['nama']; ?>"><br>
			<input type="text" name="deskripsi" placeholder="Masukkan email" value="<?= $data['kota']['deskripsi']; ?>"><br>
			<button type="submit">Simpan</button>
		</div>
	</form>
</body>
</html>