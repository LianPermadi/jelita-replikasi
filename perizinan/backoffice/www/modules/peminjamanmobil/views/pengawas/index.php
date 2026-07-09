<!DOCTYPE html>
<html>
<head>
	<title>Menampilkan Data Realtime Tanpa Reload di PHP</title>
</head>
<body>
	<h3>Menampilkan Data Realtime PHP</h3>
	<form method="POST" class="form-user">		
		Nama   : <input type="text" name="nama" /><br />
		Status : 
		<select name="status">
			<option>PNS</option>
			<option>CPNS</option>
			<option>PPPK</option>
			<option>Honorer</option>
		</select>
		<br />
		<br />
		<button class="tombol-simpan">Simpan</button>
	</form>
	<hr />
	<table border="1">
	</table>
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="fungsi.js"></script>
</body>
</html>