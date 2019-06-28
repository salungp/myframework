<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Myframework - Build something</title>
	<style type="text/css">
		* {
			font-family: Arial, sans-serrif;
		}

		/* Style the tab */
		.tab {
		  overflow: hidden;
		  border: 1px solid #ccc;
		  background-color: #f1f1f1;
		}

		/* Style the buttons that are used to open the tab content */
		.tab button {
		  background-color: inherit;
		  float: left;
		  border: none;
		  outline: none;
		  cursor: pointer;
		  padding: 14px 16px;
		  transition: 0.3s;
		}

		/* Change background color of buttons on hover */
		.tab button:hover {
		  background-color: #ddd;
		}

		/* Create an active/current tablink class */
		.tab button.active {
		  background-color: #ccc;
		}

		/* Style the tab content */
		.tabcontent {
		  display: none;
		  padding: 6px 12px;
		  border: 1px solid #ccc;
		  border-top: none;
		}
	</style>
</head>
<body>
	<?php Flasher::get(); ?>
	<h2>Myframework</h2>
	<form action="<?= base_url('welcome/cari'); ?>" method="POST">
		<input type="text" name="cari" placeholder="Cari Disini...">
		<button type="submit">Search</button>
	</form><br>
	<form action="<?= base_url('welcome/insert'); ?>" method="POST">
		<div class="form-inline">
			<input type="text" name="nama_kota" placeholder="Masukkan nama kota"><br><br>
			<textarea name="deskripsi" placeholder="Masukkan deskripsi"></textarea><br><br>
			<button type="submit">Simpan</button>
		</div>
	</form>
	<h4>Daftar Kota</h4>
	<?php if (count($data['kota']) < 1) : ?>
		<p>Tidak ada hasil yang ditampilkan!</p>
	<?php else : ?>
		<div class="tab">
			<?php foreach ($data['kota'] as $kota) : ?>
		  		<button class="tablinks" onclick="openCity(event, '<?= $kota['nama']; ?>')"><?= $kota['nama']; ?></button>
		  	<?php endforeach; ?>
		</div>

		<?php foreach ($data['kota'] as $kota) : ?>
		  	<div id="<?= $kota['nama']; ?>" class="tabcontent">
			  	<h3><?= $kota['nama']; ?></h3>
			  	<p><?= $kota['deskripsi']; ?></p>
			  	<a href="<?= base_url('welcome/deleteKota/'.$kota['id']); ?>">Delete</a>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
	<!-- <?php
	$server = $_SERVER['PHP_SELF'];
	$server = ltrim($server, '/');
	$server = explode('/', $server);
	$url = ltrim(dirname( __FILE__ ), '/');
	$url = explode('/', $url);
	for ($i = 0;$i < count($url); $i++)
	{
		if ($url[$i] == $server[0])
		{
			echo $server[0].$url[$i];
		}
	}
	?> -->
	<!-- <br>
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
			<li><?= $user['nama']; ?> <a href="<?= base_url('welcome/deleteUser/'.$user['id']); ?>"> <a href="<?= base_url('welcome/update/'.$user['id']); ?>">Edit</a></li>
			<li><?= $user['email']; ?></li>
			<br><br>
		<?php endforeach; ?>
	</ul>
	<form action="<?= base_url('welcome/insertFoto'); ?>" method="POST" enctype="multipart/form-data">
		<input type="file" name="foto">
		<button type="submit">Simpan</button>
	</form>
	<ul>
		<?php foreach ($data['foto'] as $foto) : ?>
			<li><img src="<?= base_url($foto['dir']); ?>" alt="<?= $foto['nama']; ?>"></li>
			<br><br>
		<?php endforeach; ?>
	</ul> -->
	<script type="text/javascript">
		function openCity(evt, cityName) {
		  // Declare all variables
		  var i, tabcontent, tablinks;

		  // Get all elements with class="tabcontent" and hide them
		  tabcontent = document.getElementsByClassName("tabcontent");
		  for (i = 0; i < tabcontent.length; i++) {
		    tabcontent[i].style.display = "none";
		  }

		  // Get all elements with class="tablinks" and remove the class "active"
		  tablinks = document.getElementsByClassName("tablinks");
		  for (i = 0; i < tablinks.length; i++) {
		    tablinks[i].className = tablinks[i].className.replace(" active", "");
		  }

		  var n = document.getElementById(cityName);

		  // Show the current tab, and add an "active" class to the button that opened the tab
		  n.style.display = "block";
		  evt.currentTarget.className += " active";
		}
	</script>
</body>
</html>