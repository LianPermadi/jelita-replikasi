<?php 
	include "koneksi.php";
	$nama	=$_POST['nama'];
	$status	=$_POST['status']; 
	$insert	=mysqli_query($connect, "INSERT INTO tb_pegawai (nama, status) VALUES ('$nama', '$status')");
?>